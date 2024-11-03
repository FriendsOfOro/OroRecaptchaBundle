 Oro ReCAPTCHA Bundle
==============================
This bundle adds [Google ReCAPTCHA](https://developers.google.com/recaptcha/) protection for various Oro features.

Features which can currently be protected are:
* Registration Form
* Contact Us Form

Extends the Symfony [EWZRecaptchaBundle by excelwebzone](https://github.com/excelwebzone/EWZRecaptchaBundle)

Requirements
-------------------
This bundle supports the following Oro Platform versions:

* Oro Platform v3.x
  - Support for this version is on the "v3.x" branch
  
* Oro Platform v4.1.x
  - Support for this version is on the "v4.1.x" branch

* Oro Platform v4.2.x
    - Support for this version is on the "v4.2.x" branch

* Oro Platform v5.x
    - Support for this version is on the "v5.x" branch

* Oro Platform v6.0.x
    - Support for this version is on the "v6.0.x" branch

The Master branch will always track support for the latest released Oro Platform version.

Installation and Usage
-------------------
**NOTE: Adjust instructions as needed for your local environment**

1. Install via Composer:
    ```bash
    composer require friendsoforo/oro-recaptcha-bundle
    ```
1. Update your config.yml:
    ```yaml
    # app/config/config.yml
    
    ewz_recaptcha:
        public_key:  here_is_your_public_key
        private_key: here_is_your_private_key
   
        # Not needed as "%kernel.default_locale%" is the default value for the locale key
        # locale_key:  %kernel.default_locale%
   
        # etc. Refer to the ewz_recaptcha package for more information.
    ```
1. Purge Oro cache:
    ```bash
    php bin/console cache:clear --env=prod
    ```
1. Login to Oro Admin
1. Navigate to **System Configuration => Integrations => ReCAPTCHA**
1. Configure the ReCAPTCHA widget and enabled/disable Protected Features
1. Save the configuration and verify that it is now appearing on the frontend website

Testing in Development
-------------------
Copy the `config.yml` values into `config_dev.yml` and replace the public/private keys with the test keys provided by Google:
https://developers.google.com/recaptcha/docs/faq#id-like-to-run-automated-tests-with-recaptcha-what-should-i-do

The widget should render on the forms, but will be overlaid with the text:

_"This reCAPTCHA is for testing purposes only. Please report to the site admin if you are seeing this.
"_

Adding to new Form Types
-------------------
1. Create a new Form Type Extension which extends `HackOro\RecaptchaBundle\Form\Extension\AbstractRecaptchaTypeExtension`
    ```php
    <?php
    namespace Acme\CustomBundle\Form\Extension;
    
    use Acme\CustomBundle\Form\Type\CustomPageType;
    
    class CustomPageTypeExtension extends AbstractRecaptchaTypeExtension
    {
        public function getExtendedType()
        {
            // The Form Type we are extending
            return CustomPageType::class;
        }
    
        /**
         * Protect the Custom Page Form?
         * @return boolean
         */
        public function isProtected()
        {
            // Replace this with a configuration option if needed
            return true;
        }
    }
    ```
1. Register the Form Type Extension via `services.yml`:
    ```yaml
    hack_oro_recaptcha.form.registration_form_type_extension:
        class: Acme\CustomBundle\Form\Extension\CustomPageTypeExtension
        calls:
            - [setConfigManager, ['@oro_config.user']]
        tags:
            - { name: form.type_extension, extended_type: Acme\CustomBundle\Form\Type\CustomPageType }
    ``` 

Roadmap / Remaining Tasks
-------------------
- [ ] Add support for ["Invisible" ReCAPTCHA v2](https://developers.google.com/recaptcha/docs/invisible)
- [ ] Add support for [ReCAPTCHA v3](https://developers.google.com/recaptcha/docs/v3)
- [ ] Add ability to customize ReCAPTCHA v3 score threshold on a per-feature basis
- [ ] Add ability to set public/private keys via Oro Configuration instead of YAML files  

Licence
-------------------
[MIT - MIT License](./LICENSE)