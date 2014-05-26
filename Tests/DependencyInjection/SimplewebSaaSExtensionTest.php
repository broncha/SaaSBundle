<?php
/**
 * Created by PhpStorm.
 * User: broncha
 * Date: 5/25/14
 * Time: 5:02 PM
 */

namespace Simpleweb\SaaSBundle\Tests\DependencyInjection;


use Simpleweb\SaaSBundle\DependencyInjection\SimplewebSaaSExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dump\Container;
use Symfony\Component\Yaml\Parser;

class SimplewebSaaSExtensionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ContainerBuilder
     */
    protected $builder;

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testUserLoadThrowsExceptionIfSubscriptionClassNotSet()
    {
        $loader = new SimplewebSaaSExtension();
        $config = $this->getConfig();

        unset($config['subscription']['class']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testUserLoadThrowsExceptionIfPlanClassNotSet()
    {
        $loader = new SimplewebSaaSExtension();
        $config = $this->getConfig();

        unset($config['plan']['class']);
        $loader->load(array($config), new ContainerBuilder());
    }

    public function testSetSubscriptionClass(){
        $this->createConfiguration();
        $this->assertParameter('Broncha\UserBundle\Entity\UserSubscription', 'simple_saas.subscription.class');
    }

    public function testSetPlanClass(){
        $this->createConfiguration();
        $this->assertParameter('Broncha\UserBundle\Entity\UserPlan', 'simple_saas.plan.class');
    }

    protected function createConfiguration(){
        $this->builder = new ContainerBuilder();
        $loader = new SimplewebSaaSExtension();

        $config = $this->getConfig();
        $loader->load(array($config), $this->builder);
        $this->assertTrue($this->builder instanceof ContainerBuilder);
    }

    /**
     * @param string $value
     * @param string $key
     */
    private function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->builder->getAlias($key), sprintf('%s alias is correct', $key));
    }

    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->builder->getParameter($key), sprintf('%s parameter is correct', $key));
    }

    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->builder->hasDefinition($id) ?: $this->builder->hasAlias($id)));
    }

    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->builder->hasDefinition($id) ?: $this->builder->hasAlias($id)));
    }

    protected function tearDown()
    {
        unset($this->builder);
    }

    /**
     * @return mixed
     */
    protected function getConfig(){
        $yaml = <<<EOF
subscription:
    class: 'Broncha\UserBundle\Entity\UserSubscription'
plan:
    class: 'Broncha\UserBundle\Entity\UserPlan'
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
 