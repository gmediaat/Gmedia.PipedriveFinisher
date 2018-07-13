<?php
namespace Gmedia\PipedriveFinisher\Finishers;

use Neos\Flow\Annotations as Flow;
use Neos\Form\Exception\FinisherException;
use Gmedia\PipedriveFinisher\AbstractFinisher;

/**
 * This finisher creates an activity in Pipedrive
 */

class ActivityFinisher extends AbstractFinisher
{

    /**
     * Default activity type
     * @Flow\InjectConfiguration(path="Form.Finisher.Activity.defaultValue")
     * @var String
     */
    protected $defaultType = '';

    /**
     * API endpoint name
     * @var String
     */
    protected $apiEndpoint = 'activities';

    /**
     * Name of the scope
     * @var String
     */
    protected $scope = 'Activity';

    /**
     * @var array
     */
    protected $defaultOptions = array(
        'subject' => '',
        'done' => true,
        'identifier' => '',
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

        if ($testMode === true) {
          \Neos\Flow\var_dump($data);
        } else {
          $this->callAPI($data);
        }
    }
}
