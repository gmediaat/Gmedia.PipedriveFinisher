<?php
namespace GradinaruFelix\Pipedrive\Finishers;

use Neos\Flow\Annotations as Flow;
use Neos\Form\Core\Model\AbstractFinisher;
use Neos\Form\Exception\FinisherException;
use GradinaruFelix\Pipedrive\Utility\Api as PipedriveApi;

/**
 * This finisher creates a activity in Pipedrive
 */

class ActivityFinisher extends AbstractFinisher
{

    const OMITTED_OPTIONS = array(
      'testMode',
    );

    /**
     * Default activity type
     * @Flow\InjectConfiguration(path="Form.Finisher.Activity.defaultValue")
     * @var String
     */
    protected $defaultType = '';

    /**
     * @var array
     */
    protected $defaultOptions = array(
        'subject' => '',
        'done' => true,
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

        // TODO: better solution for this
        $this->defaultValue['type'] = $this->defaultType;

        foreach($this->options as $optionName => $optionValue) {
          if(!array_key_exists($optionName, self::OMITTED_OPTIONS)) {
            $data[$optionName] = $this->parseOption($optionName);
          }
        }

        $apiUtility = new PipedriveApi('activities');
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
