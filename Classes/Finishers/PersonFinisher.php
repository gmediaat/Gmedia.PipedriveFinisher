<?php
namespace Gmedia\PipedriveFinisher\Finishers;

use Neos\Form\Exception\FinisherException;
use Gmedia\PipedriveFinisher\AbstractFinisher;

/**
 * This finisher sends an email to one or more recipients
 */

class PersonFinisher extends AbstractFinisher
{

    /**
     * API endpoint name
     * @var String
     */
    protected $apiEndpoint = 'persons';

    /**
     * Name of the scope
     * @var String
     */
    protected $scope = 'Person';

    /**
     * @var array
     */
    protected $defaultOptions = array(
        'name' => '',
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

        if ($testMode === true) {
          \Neos\Flow\var_dump($data);
        } else {
          $this->callAPI($data);
        }
    }
}
