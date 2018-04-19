<?php
namespace GradinaruFelix\Pipedrive\Finishers;

use Neos\Flow\Annotations as Flow;
use Neos\Form\Core\Model\AbstractFinisher;
use Neos\Form\Exception\FinisherException;
use GradinaruFelix\Pipedrive\Utility\Api as PipedriveApi;

/**
 * This finisher sends an email to one or more recipients
 */

class NoteFinisher extends AbstractFinisher
{

    const OMITTED_OPTIONS = array(
      'testMode',
    );

    /**
     * @var array
     */
    protected $defaultOptions = array(
        'content' => '',
        'testMode' => false,
    );

    /**
     * Executes this finisher
     * @see AbstractFinisher::execute()
     *
     * @return void
     * @throws FinisherException
     */
    protected function executeInternal()
    {
        $data = array();
        $testMode = $this->parseOption('testMode');

        foreach($this->options as $optionName => $optionValue) {
          if(!array_key_exists($optionName, self::OMITTED_OPTIONS)) {
            $data[$optionName] = $this->parseOption($optionName);
          }
        }

        $apiUtility = new PipedriveApi('notes');
        $apiUtility->setData($data);

        $formState = $this->finisherContext->getFormRuntime()->getFormState();

        if ($testMode === true) {

        } else {
          $response = $apiUtility->execute();
          $formState->setFormValue("Pipedrive.ActivityFinisher.ID", $response->data->id);
          print_r($formState->getFormValues());
        }
    }
}