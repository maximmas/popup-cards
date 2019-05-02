<?php
/** 
 *  Модальное окно
 * 
 */
?>

<?php
	// get data from settings
	$show = 1;
	$options		= get_option( 'cj_options' );
		$title			= ( $options ) ? $options['title'] : "Choose your card";
	$delay			= ( !empty( $options['delay'] ) ) ? $options['delay'] : 0;
	$text_win		= ( $options ) ? $options['text_win'] : "You win";
	$text_lose	= ( $options ) ? $options['text_lose'] : "You lose";
	if ( $options ) $show = ( array_key_exists( 'not_show', $options ) ) ? 0 : 1;
	
	
?>

<div id="cj_modal" class="cj_modal white-popup mfp-hide" data-delay="<?php echo esc_attr( $delay ); ?>" data-show="<?php echo esc_attr( $show ); ?>">
	<h3 class="modal_title">
		<?php echo esc_html( $title ); ?>
	</h3>
					<div class="cards_container">

						<article class="card_item">
							<div class="card_item-overlay"></div>
							<div class="card_content">
								<img src="<?php echo esc_attr( plugins_url( 'assets/img/question.svg', dirname(__FILE__) )); ?>" alt="question" class="img-fluid">
								<div class="card_text">
									<span></span>
								</div>
							</div>
						</article>

						<article class="card_item">
							<div class="card_item-overlay"></div>
							<div class="card_content">
								<img src="<?php echo esc_attr( plugins_url( 'assets/img/question.svg', dirname(__FILE__) )); ?>" alt="question" class="img-fluid">
								<div class="card_text">
									<span></span>
								</div>
							</div>
						</article>

						<article class="card_item">
							<div class="card_item-overlay"></div>
							<div class="card_content">
								<img src="<?php echo esc_attr( plugins_url( 'assets/img/question.svg', dirname(__FILE__) )); ?>" alt="question" class="img-fluid">
								<div class="card_text">
									<span></span>
								</div>
							</div>
						</article>

						<article class="card_item">
							<div class="card_item-overlay"></div>
							<div class="card_content">
								<img src="<?php echo esc_attr( plugins_url( 'assets/img/question.svg', dirname(__FILE__) )); ?>" alt="question" class="img-fluid">
								<div class="card_text">
									<span></span>
								</div>
							</div>
						</article>

				</div>
		
		<form method="POST"  class="modal_form">
			<input type="text" class="modal_name" name="modal_name" placeholder="Name" aria-label="Name" required>
			<input type="email" class="modal_email" name="modal_email" placeholder="Email" aria-label="Email" required>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		<div class="form_response"></div>
		
		<p class="text_win" hidden><?php echo esc_html( $text_win ); ?></p>
		<p class="text_lose" hidden><?php echo esc_html( $text_lose ); ?></p>
</div>
