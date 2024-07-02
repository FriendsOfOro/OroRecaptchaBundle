<?php
/**
 * @category  HackOro
 * @package   ReCaptchaBundle
 * @author    Chris Rossi <chris.rossi@aligent.com.au>
 * @copyright 2019 Aligent Consulting & Friends of Oro
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace HackOro\RecaptchaBundle\DependencyInjection;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const PUBLIC_KEY = 'public_key';
    const PRIVATE_KEY = 'private_key';
    const THEME = 'theme';
    const SIZE = 'size';
    const PROTECT_REGISTRATION = 'protect_registration';
    const PROTECT_CONTACT_FORM = 'protect_contact_form';

    /**
     * Generates the configuration tree builder.
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(HackOroRecaptchaExtension::ALIAS);
        $rootNode = $treeBuilder->getRootNode();

        SettingsBuilder::append(
            $rootNode,
            [
                self::PUBLIC_KEY => ['type' => 'text', 'value' => ''],
                self::PRIVATE_KEY => ['type' => 'text', 'value' => ''],
                self::THEME => ['type' => 'scalar', 'value' => 'light'], // light/dark (default light)
                self::SIZE => ['type' => 'scalar', 'value' => 'normal'], // normal/compact (default normal)
                self::PROTECT_REGISTRATION => ['type' => 'boolean', 'value' => true],
                self::PROTECT_CONTACT_FORM => ['type' => 'boolean', 'value' => true],
            ]
        );
        return $treeBuilder;
    }

    /**
     * Returns full key name by it's last part
     *
     * @param $name string last part of the key name (one of the class cons can be used)
     * @return string full config path key
     */
    public static function getConfigKeyByName(string $name): string
    {
        return HackOroRecaptchaExtension::ALIAS . ConfigManager::SECTION_MODEL_SEPARATOR . $name;
    }
}
