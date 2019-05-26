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

		$this->add_control( 'display_type', [
			'label'   => __( 'Display Type', 'timerelement' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => [
				'clock'    => __( 'Clock', 'timerelement' ),
				'timerc'   => __( 'Time CountDown', 'timerelement' ),
				'genericc' => __( 'Normal CountDown', 'timerelement' ),
			],
			'default' => 'clock'
		] );

		$this->add_control( 'clock_format', [
			'label'     => __( 'Clock Format', 'timerelement' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'options'   => [
				'12' => __( '12 Hour', 'timerelement' ),
				'24' => __( '24 Hour', 'timerelement' ),
			],
			'default'   => '12',
			'condition' => [
				'display_type' => 'clock'
			]
		] );


		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$display_type = $this->get_settings('display_type');
		$clock_format = $this->get_settings('clock_format');
		?>
        <div class="clock"
             data-display-type="<?php echo $display_type ?>"
             data-clock-format="<?php echo $clock_format ?>"
        ></div>
		<?php
	}

	/*protected function _content_template() {

	}*/
}