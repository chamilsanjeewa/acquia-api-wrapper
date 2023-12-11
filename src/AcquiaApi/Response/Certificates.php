<?php

namespace Umndrupal\acquia_api\Response;

use Umndrupal\acquia_api\Client\Client;

class Certificates extends AcquiaResponse {

  /**
   * @var string
   */
  protected $id;

  /**
   * @var array
   */
  protected $csr_data;

  public function __construct($response, Client $client)
  {
    parent::__construct($response, $client);
    $properties = [
      'id',
    ];
    $this->id = $response['id'];
  }

  public function getEnvironment(): string
  {
    return $this->id;
  }

  public function getCSR() {
    $uri = "environments/{$this->id}/ssl/csrs";
    $options = [
      'headers' => [
        'Content-Type' => 'application/hal+json',
      ],
    ];
    $response = $this->client->getRequest($uri, $options);
    return $response->getBody()->getContents();
  }


  public function generateCSR($csr_data, $common_name, $csr_alternate_names=[]) {
    $uri = "environments/{$this->id}/ssl/csrs";
    $csr_data["common_name"] = $common_name;
    $csr_data["alternate_names"] = $csr_alternate_names;
    $options = [
      'headers' => [
        'Content-Type' => 'application/hal+json',
      ],
      'form_params' => $csr_data,
    ];
    $response = $this->client->postRequest($uri, $options);
    return new AcquiaResponse($response, $this->client);
  }

  public function deleteCSR($csrID) {
    $uri = "environment/{$this->id}/ssl/csrs/{$csrID}";
    $options = [
      'headers' => [
        'Content-Type' => 'application/hal+json',
      ],
    ];
    $response = $this->client->delete($uri, $options);
    return new AcquiaResponse($response, $this->client);
  }

  public function getCertificates() {
    $uri = "/environments/{$this->id}/ssl/certificates";
    $options = [
      'headers' => [
        'Content-Type' => 'application/hal+json',
      ],
    ];
    $response = $this->client->getRequest($uri, $options);
    return $response->getBody()->getContents();
  }

  public function installCertificate() {
  }

  public function deleteCertificate() {
  }

  public function activateCertificate() {
  }

  public function deactivateCertificate() {
  }
}
