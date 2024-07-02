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
use Oro\Bundle\ContactUsBundle\Form\Type\ContactRequestType;

class ContactUsTypeExtension extends AbstractRecaptchaTypeExtension
{
    public function getExtendedType(): string
    {
        return ContactRequestType::class;
    }

    /**
     * Protect the Contact Us Form?
     */
    public function isProtected(): bool
    {
        return $this->getConfiguration(Configuration::PROTECT_CONTACT_FORM, false);
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [ContactRequestType::class];
    }
}
