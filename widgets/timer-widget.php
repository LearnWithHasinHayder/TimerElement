<?php

class Elementor_Timer_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return "TimerWidget";
	}

	public function get_title() {
		return __( "Timer Widget", 'timerelement' );
	}

	public function get_icon() {
		return 'fa fa-clock-o';
	}

	public function get_categories() {
		return array( 'LWHH' );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'timerelement' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);




		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
	}

	/*protected function _content_template() {

	}*/
}