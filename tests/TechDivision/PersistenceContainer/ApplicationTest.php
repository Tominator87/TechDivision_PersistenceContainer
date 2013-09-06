<?php 

/**
 * TechDivision\PersistenceContainer\ApplictionTest
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace TechDivision\PersistenceContainer;

use TechDivision\ApplicationServer\Configuration;
use TechDivision\ApplicationServer\InitialContext;

/**
 * @package     TechDivision\PersistenceContainer
 * @copyright  	Copyright (c) 2013<info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    
	/**
	 * The server instance to test.
	 * @var TechDivision\PersistenceContainer\Application
	 */
	protected $application;

    /**
     * A dummy application name for testing purposes.
     * @var string
     */
    protected $applicationName = 'testApplication';
    
	/**
	 * Initializes the application instance to test.
	 *
	 * @return void
	 */
	public function setUp()
	{
	    $configuration = new Configuration();
        $configuration->initFromFile(__DIR__ . '/_files/appserver_initial_context.xml');
		$initialContext = new InitialContext($configuration);
		$this->application = new Application($initialContext, $this->applicationName);
	    $this->application->setConfiguration($this->getContainerConfiguration());
	    $databaseConfiguration = new Configuration();
	    $databaseConfiguration->initFromFile(__DIR__ . '/_files/META-INF/appserver-ds.xml');
	    $this->application->setDatabaseConfiguration($databaseConfiguration);
	}
	
	/**
	 * Test if the database configuration has been passed successfully.
	 * 
	 * @return void
	 */
	public function testGetDatabaseConfiguration()
	{
		$this->assertInstanceOf('\TechDivision\ApplicationServer\Configuration', $this->application->getDatabaseConfiguration());
	}
	
	/**
	 * Returns a dummy container configuration.
	 * 
	 * @return \TechDivision\ApplicationServer\Configuration The dummy configuration
	 */
	public function getContainerConfiguration() {
	    $configuration = new Configuration();
	    $configuration->initFromFile(__DIR__ . '/_files/appserver_container.xml');
	    $configuration->addChildWithNameAndValue('baseDirectory', '/opt/appserver');
	    return $configuration;
	}
}