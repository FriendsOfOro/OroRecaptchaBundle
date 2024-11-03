<?php
/**
 * @category  HackOro
 * @package   ReCaptchaBundle
 * @author    Chris Rossi <chris.rossi@aligent.com.au>
 * @copyright 2019 Aligent Consulting & Friends of Oro
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace HackOro\RecaptchaBundle\Form\Extension;

use HackOro\RecaptchaBundle\DependencyInjection\Configuration;
use Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserRegistrationType;

class RegistrationTypeExtension extends AbstractRecaptchaTypeExtension
{
    public function getExtendedType(): string
    {
        return FrontendCustomerUserRegistrationType::class;
    }

    /**
     * Protect the Registration Form?
     */
    public function isProtected(): bool
    {
        return $this->getConfiguration(Configuration::PROTECT_REGISTRATION, false);
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [FrontendCustomerUserRegistrationType::class];
    }
}
