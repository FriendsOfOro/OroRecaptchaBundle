<?php
/**
 * @category  HackOro
 * @package   ReCaptchaBundle
 * @author    Chris Rossi <chris.rossi@aligent.com.au>
 * @copyright 2019 Aligent Consulting & Friends of Oro
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace HackOro\RecaptchaBundle\Form\Extension;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use HackOro\RecaptchaBundle\DependencyInjection\Configuration;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

abstract class AbstractRecaptchaTypeExtension extends AbstractTypeExtension
{
    const DEFAULT_THEME = 'light';
    const DEFAULT_SIZE = 'normal';

    /** @var ConfigManager */
    protected $configManager;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->isProtected()) {

            $builder->add('recaptcha', EWZRecaptchaType::class, [
                'attr' => [
                    'options' => [
                        'theme' => $this->getTheme(),
                        'type'  => 'image',
                        'size'  => $this->getSize(),
                    ]
                ],
                'mapped'      => false,
                'constraints' => [
                    new RecaptchaTrue(),
                ],
            ]);
        }
    }

    /**
     * @param ConfigManager $configManager
     */
    public function setConfigManager(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    /**
     * @return mixed
     */
    protected function getTheme()
    {
        return $this->getConfiguration(Configuration::THEME, self::DEFAULT_THEME);
    }

    /**
     * @return mixed
     */
    protected function getSize()
    {
        return $this->getConfiguration(Configuration::SIZE, self::DEFAULT_SIZE);
    }

    /**
     * Get configuration option
     * @param string $key
     * @param $default
     * @return mixed
     */
    protected function getConfiguration(string $key, $default)
    {
        return $this->configManager->get(Configuration::getConfigKeyByName($key), $default);
    }

    /**
     * @return boolean
     */
    abstract public function isProtected();

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    abstract public function getExtendedType();

}