<?php

namespace Symfony\Config;

require_once __DIR__.\DIRECTORY_SEPARATOR.'SymfonycastsSass'.\DIRECTORY_SEPARATOR.'SassOptionsConfig.php';

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class SymfonycastsSassConfig implements \Symfony\Component\Config\Builder\ConfigBuilderInterface
{
    private $rootSass;
    private $binary;
    private $sassOptions;
    private $embedSourcemap;
    private $_usedProperties = [];

    /**
     * @param ParamConfigurator|list<ParamConfigurator|mixed>|mixed $value
     *
     * @return $this
     */
    public function rootSass(mixed $value): static
    {
        $this->_usedProperties['rootSass'] = true;
        $this->rootSass = $value;

        return $this;
    }

    /**
     * The Sass binary to use
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function binary($value): static
    {
        $this->_usedProperties['binary'] = true;
        $this->binary = $value;

        return $this;
    }

    /**
     * @default {"style":"expanded","source_map":true,"embed_source_map":"%kernel.debug%","load_path":[]}
    */
    public function sassOptions(array $value = []): \Symfony\Config\SymfonycastsSass\SassOptionsConfig
    {
        if (null === $this->sassOptions) {
            $this->_usedProperties['sassOptions'] = true;
            $this->sassOptions = new \Symfony\Config\SymfonycastsSass\SassOptionsConfig($value);
        } elseif (0 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "sassOptions()" has already been initialized. You cannot pass values the second time you call sassOptions().');
        }

        return $this->sassOptions;
    }

    /**
     * @default null
     * @param ParamConfigurator|bool $value
     * @deprecated Option "embed_sourcemap" at "symfonycasts_sass" is deprecated. Use "sass_options.embed_source_map" instead".
     * @return $this
     */
    public function embedSourcemap($value): static
    {
        $this->_usedProperties['embedSourcemap'] = true;
        $this->embedSourcemap = $value;

        return $this;
    }

    public function getExtensionAlias(): string
    {
        return 'symfonycasts_sass';
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('root_sass', $value)) {
            $this->_usedProperties['rootSass'] = true;
            $this->rootSass = $value['root_sass'];
            unset($value['root_sass']);
        }

        if (array_key_exists('binary', $value)) {
            $this->_usedProperties['binary'] = true;
            $this->binary = $value['binary'];
            unset($value['binary']);
        }

        if (array_key_exists('sass_options', $value)) {
            $this->_usedProperties['sassOptions'] = true;
            $this->sassOptions = new \Symfony\Config\SymfonycastsSass\SassOptionsConfig($value['sass_options']);
            unset($value['sass_options']);
        }

        if (array_key_exists('embed_sourcemap', $value)) {
            $this->_usedProperties['embedSourcemap'] = true;
            $this->embedSourcemap = $value['embed_sourcemap'];
            unset($value['embed_sourcemap']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['rootSass'])) {
            $output['root_sass'] = $this->rootSass;
        }
        if (isset($this->_usedProperties['binary'])) {
            $output['binary'] = $this->binary;
        }
        if (isset($this->_usedProperties['sassOptions'])) {
            $output['sass_options'] = $this->sassOptions->toArray();
        }
        if (isset($this->_usedProperties['embedSourcemap'])) {
            $output['embed_sourcemap'] = $this->embedSourcemap;
        }

        return $output;
    }

}
