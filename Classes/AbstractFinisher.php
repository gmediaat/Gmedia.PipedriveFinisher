<?php
namespace Gmedia\PipedriveFinisher;

use Neos\Flow\Annotations as Flow;
use Neos\Form\Core\Model\AbstractFinisher as NeosFormAbstractFinisher;
use Neos\Form\Exception\FinisherException;
use Gmedia\PipedriveFinisher\Utility\Api as PipedriveApi;

abstract class AbstractFinisher extends NeosFormAbstractFinisher
{

  const OMITTED_OPTIONS = array(
    'testMode',
    'identifier',
  );



  protected function getIdentifier() {
    $scope = $this->scope;
    $customIdentifier = $this->parseOption('identifier');

    if($customIdentifier) {
      $identifier = "Pipedrive." . $customIdentifier;
    } else {
      $identifier = "Pipedrive." . $scope . "Finisher";
    }

    return $identifier;
  }

  /**
   * Runs the API request for the given data
   *
   * @return bool
   * @throws FinisherException
   */
  protected function callAPI($data) {
    $apiUtility = new PipedriveApi($this->apiEndpoint);
    $apiUtility->setData($data);

    $formState = $this->finisherContext->getFormRuntime()->getFormState();

    $response = $apiUtility->execute();

    if($response->data->id) {
      $formState->setFormValue($this->getIdentifier() . ".ID", $response->data->id);
      return true;
    } else {
      throw new FinisherException("Something went wrong while calling the API!");
    }
  }

}
