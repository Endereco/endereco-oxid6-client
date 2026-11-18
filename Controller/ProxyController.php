<?php

namespace Endereco\Oxid6Client\Controller;

use Endereco\Oxid6Client\Component\EnderecoService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use OxidEsales\Eshop\Core\Registry;

/**
 * Forwards Endereco JSON-RPC requests from the frontend to the Endereco service.
 *
 * The API key and the remote service URL are read from the module configuration
 * server-side, so they never reach the browser. Replaces the former proxy/io.php.
 */
class ProxyController extends \OxidEsales\Eshop\Application\Controller\FrontendController
{
    /**
     * @var string Module id used to resolve the module configuration.
     */
    private $moduleId = 'endereco-oxid6-client';

    /**
     * Forwards Endereco RPC requests server-side.
     *
     * @return string
     */
    public function render()
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            http_response_code(405);
            $this->respondJson(['error' => 'Only POST requests are allowed.']);
        }

        if (!Registry::getSession()->checkSessionChallenge()) {
            http_response_code(403);
            $this->respondJson(['error' => 'Invalid or missing session token.']);
        }

        $payload = json_decode((string) file_get_contents('php://input'), true);
        if (!is_array($payload)) {
            http_response_code(400);
            $this->respondJson(['error' => 'Invalid JSON payload.']);
        }

        $config = Registry::getConfig();
        $shopId = (string) $config->getShopId();
        $moduleName = 'module:' . $this->moduleId;
        $apiKey = trim((string) $config->getShopConfVar('sAPIKEY', $shopId, $moduleName));
        $endpoint = trim((string) $config->getShopConfVar('sSERVICEURL', $shopId, $moduleName));

        if ('' === $apiKey || '' === $endpoint) {
            http_response_code(500);
            $this->respondJson(['error' => 'Endereco configuration is incomplete.']);
        }

        $moduleVersions = (array) $config->getConfigParam('aModuleVersions');
        $agentInfo = 'Endereco Oxid6 Client v' . (string) ($moduleVersions[$this->moduleId] ?? '0.0.0');

        // The JS SDK sends the Endereco session id as transaction id header.
        $transactionId = trim((string) ($_SERVER['HTTP_X_TRANSACTION_ID'] ?? ''));
        if ('' === $transactionId) {
            $transactionId = 'not_set';
        }

        $headers = [
            'Content-Type' => 'application/json',
            'X-Auth-Key' => $apiKey,
            'X-Transaction-Id' => $transactionId,
            'X-Transaction-Referer' => EnderecoService::getTransactionReferer(),
            'X-Agent' => $agentInfo,
        ];

        try {
            // http_errors=false passes error responses of the service through to the client.
            $client = new Client(['timeout' => 8.0, 'http_errors' => false]);
            $response = $client->send(new Request('POST', $endpoint, $headers, (string) json_encode($payload)));
            http_response_code($response->getStatusCode());
            $this->respondRaw((string) $response->getBody());
        } catch (\Throwable $exception) {
            http_response_code(502);
            $this->respondJson(['error' => 'Endereco backend request failed.']);
        }
    }

    /**
     * @param array<string, mixed> $payload
     *
     * @return never
     */
    private function respondJson($payload)
    {
        header('Content-Type: application/json');
        echo json_encode($payload);
        exit();
    }

    /**
     * @param string $body
     *
     * @return never
     */
    private function respondRaw($body)
    {
        header('Content-Type: application/json');
        echo $body;
        exit();
    }
}
