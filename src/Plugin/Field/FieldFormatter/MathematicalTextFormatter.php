<?php

namespace Drupal\mathematical_lexer_parser\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\mathematical_lexer_parser\MathematicalLexerParserServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'mathematcal_text_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "mathematical_text_formatter",
 *   label = @Translation("Mathematical text formatter"),
 *   field_types = {
 *     "text",
 *     "string"
 *   }
 * )
 */
class MathematicalTextFormatter extends FormatterBase implements ContainerFactoryPluginInterface {


    /**
     *
     * Mathematical lexer parser service.
     * @var \Drupal\mathematical_lexer_parser\MathematicalLexerParserServiceInterface
     */
    protected $mathematical_lexer_parser;


    /**
     * MathematicalTextFormatter constructor.
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param FieldDefinitionInterface $field_definition
     * @param array $settings
     * @param string $label
     * @param string $view_mode
     * @param array $third_party_settings
     * @param MathematicalLexerParserServiceInterface $mathematicalLexerPparser
     */
    public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings,MathematicalLexerParserServiceInterface $mathematicalLexerPparser) {
        parent::__construct($plugin_id, $plugin_definition,  $field_definition,  $settings, $label, $view_mode, $third_party_settings);
        $this->mathematical_lexer_parser = $mathematicalLexerPparser;
    }


    /**
     * @param ContainerInterface $container
     * @param array $configuration
     * @param $plugin_id
     * @param $plugin_definition
     * @return static
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $plugin_id,
            $plugin_definition,
            $configuration['field_definition'],
            $configuration['settings'],
            $configuration['label'],
            $configuration['view_mode'],
            $configuration['third_party_settings'],
            $container->get('mathematical_lexer_parser.default')
        );
    }
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
      $elements = [];

      foreach ($items as $delta => $item) {
          $elements[$delta] = [
              '#theme' => 'mathematical_lexer_parser',
              '#expression' => $item->value,
              '#result' => $this->mathematical_lexer_parser->calculate($item->value),
              '#attached' => [
                  'library' => [
                      'mathematical_lexer_parser/mathematical_lexer_parser.base',
                  ],
              ],
          ];
      }
      return $elements;
  }
}
