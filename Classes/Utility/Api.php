<?php
namespace GradinaruFelix\Pipedrive\Utility;

use Neos\Flow\Annotations as Flow;

class Api
{

  /**
   * @var array
   */
  protected $settings;

  /**
   * Company domain used to build the URI
   * @Flow\InjectConfiguration(path="Api.Domain")
   * @var String
   */
  protected $companyDomain = '';

  /**
   * Token used for authenticating to the API
   * @Flow\InjectConfiguration(path="Api.Token")
   * @var String
   */
  protected $apiToken = '';

  /**
   * Endpoint to be called
   * @var String
   */
  protected $apiEndpoint = '';

  /**
   * Endpoint to be called
   * @var array
   */
  protected $data = array();

  /**
   * @param String $endpoint
   * @return void
  */
  public function __construct(String $endpoint)
  {
    $this->apiEndpoint = $endpoint;
  }

  /**
   * Inject the settings
   *
   * @param array $settings
   * @return void
   */
  public function injectSettings(array $settings) {
      $this->settings = $settings;
  }

  /**
   * Setter function for the data
   *
   * @param array $data
   * @return void
   */
  public function setData(array $data) {
      $this->data = $data;
  }

  /**
   * Builds the complete URI to the API endpoint
   * @return void
   */
  public function execute()
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->getURI());
    var_dump($this->getURI());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);

    $response = curl_exec($ch);
    $result = json_decode($response);
    var_dump($result);
    curl_close($ch);

    if (empty($result) || !$result->success) {
      throw new \Exception("Pipedrive API error!");
    }
  }

  /**
   * Builds the complete URI to the API endpoint
   * @return String
   */
  protected function getURI()
  {
    return "https://" . $this->companyDomain . ".pipedrive.com/v1/" .
      $this->apiEndpoint . "?api_token=" . $this->apiToken;
  }
}
