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

    protected ConfigManager $configManager;

    public function buildForm(FormBuilderInterface $builder, array $options): void
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

    public function setConfigManager(ConfigManager $configManager): void
    {
        $this->configManager = $configManager;
    }

    protected function getTheme(): mixed
    {
        return $this->getConfiguration(Configuration::THEME, self::DEFAULT_THEME);
    }

    protected function getSize(): mixed
    {
        return $this->getConfiguration(Configuration::SIZE, self::DEFAULT_SIZE);
    }

    /**
     * Get configuration option
     */
    protected function getConfiguration(string $key, mixed $default = null): mixed
    {
        return $this->configManager->get(Configuration::getConfigKeyByName($key)) ?? $default;
    }

    abstract public function isProtected(): bool;
}
