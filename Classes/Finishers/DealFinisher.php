<?php
namespace GradinaruFelix\Pipedrive\Finishers;

use Neos\Flow\Annotations as Flow;
use Neos\Form\Exception\FinisherException;
use GradinaruFelix\Pipedrive\AbstractFinisher;
use GradinaruFelix\Pipedrive\Utility\Api as PipedriveApi;

/**
 * This finisher creates a deal in Pipedrive
 */

class DealFinisher extends AbstractFinisher
{

    /**
     * API endpoint name
     * @var String
     */
    protected $apiEndpoint = 'deals';

    /**
     * Name of the scope
     * @var String
     */
    protected $scope = 'Deal';

    /**
     * @var array
     */
    protected $defaultOptions = array(
        'title' => '',
        'value' => 0,
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
