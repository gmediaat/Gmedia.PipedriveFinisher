<?php
namespace GradinaruFelix\Pipedrive\Finishers;

use Neos\Form\Exception\FinisherException;
use GradinaruFelix\Pipedrive\AbstractFinisher;
use GradinaruFelix\Pipedrive\Utility\Api as PipedriveApi;

/**
 * This finisher creates an organization in Pipedrive
 */

class OrganizationFinisher extends AbstractFinisher
{

    /**
     * API endpoint name
     * @var String
     */
    protected $apiEndpoint = 'organizations';

    /**
     * Name of the scope
     * @var String
     */
    protected $scope = 'Organization';

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
