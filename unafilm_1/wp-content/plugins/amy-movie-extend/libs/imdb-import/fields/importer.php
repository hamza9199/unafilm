<?php
defined('ABSPATH') or die;

/**
 *
 * Field: Imdb Importer
 *
 * @since 1.3.0
 * @version 1.0.0
 */

if (!class_exists('CSF_Field_Imdb_Importer')) {
	class CSF_Field_Imdb_Importer extends CSF_Fields {
		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {
			echo $this->field_before();

            ?>

            <div class="amy-imdb-importer">
                <div class="amy-imdb-overlay"></div>

                <div class="amy-imdb-info">
                    <div class="amy-imdb-actions">
                        <a href="#" class="button button-primary amy-button-install-product">
                            <?php echo esc_html__('Import', 'amy-movie-extend'); ?>
                        </a>
                    </div>
                </div>

                <div class="amy-imdb-progress-bar-wrapper">
                    <div class="amy-imdb-progress-bar"></div>
                </div>
                <div class="amy-task-log">
                </div>
            </div>

            <?php

			echo $this->field_after();
		}
	}
}

