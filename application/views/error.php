<?php
	// Unique error identifier
	$error_id = uniqid('error');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Error</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Kohana::config('app.app_url') ?>/css/styles.css" />
	</head>
<body>
<?php if (Kohana::$environment == Kohana::PRODUCTION): ?>
	<h3>Error</h3>
	<p>There is a problem with this site, please try again later.</p>	
<?php else: ?>
	<div id="app_error">
		<h3><span class="type"><?php echo $type ?> [ <?php echo $code ?> ]:</span> <span class="message"><?php echo html::chars($message) ?></span></h3>
		<div id="<?php echo $error_id ?>" class="content">
			<p><span class="file"><?php echo Debug::path($file) ?> [ <?php echo $line ?> ]</span></p>
			<?php echo Debug::source($file, $line) ?>
			<ol class="trace">
			<?php foreach (Debug::trace($trace) as $i => $step): ?>
				<li>
					<p>
						<span class="file">
							<?php if ($step['file']): $source_id = $error_id.'source'.$i; ?>
								<a href="#<?php echo $source_id ?>" onclick="return koggle('<?php echo $source_id ?>')"><?php echo Debug::path($step['file']) ?> [ <?php echo $step['line'] ?> ]</a>
							<?php else: ?>
								{<?php echo __('PHP internal call') ?>}
							<?php endif ?>
						</span>
						&raquo;
						<?php echo $step['function'] ?>(<?php if ($step['args']): $args_id = $error_id.'args'.$i; ?><a href="#<?php echo $args_id ?>" onclick="return koggle('<?php echo $args_id ?>')"><?php echo __('arguments') ?></a><?php endif ?>)
					</p>
					<?php if (isset($args_id)): ?>
					<div id="<?php echo $args_id ?>" class="collapsed">
						<table cellspacing="0">
						<?php foreach ($step['args'] as $name => $arg): ?>
							<tr>
								<td><code><?php echo $name ?></code></td>
								<td><pre><?php echo Debug::dump($arg) ?></pre></td>
							</tr>
						<?php endforeach ?>
						</table>
					</div>
					<?php endif ?>
					<?php if (isset($source_id)): ?>
						<pre id="<?php echo $source_id ?>" class="source collapsed"><code><?php echo $step['source'] ?></code></pre>
					<?php endif ?>
				</li>
				<?php unset($args_id, $source_id); ?>
			<?php endforeach ?>
			</ol>
		</div>
		<h2><a href="#<?php echo $env_id = $error_id.'environment' ?>" onclick="return koggle('<?php echo $env_id ?>')"><?php echo __('Environment') ?></a></h2>
		<div id="<?php echo $env_id ?>" class="content collapsed">
			<?php $included = get_included_files() ?>
			<h3><a href="#<?php echo $env_id = $error_id.'environment_included' ?>" onclick="return koggle('<?php echo $env_id ?>')"><?php echo __('Included files') ?></a> (<?php echo count($included) ?>)</h3>
			<div id="<?php echo $env_id ?>" class="collapsed">
				<table cellspacing="0">
					<?php foreach ($included as $file): ?>
					<tr>
						<td><code><?php echo Debug::path($file) ?></code></td>
					</tr>
					<?php endforeach ?>
				</table>
			</div>
			<?php $included = get_loaded_extensions() ?>
			<h3><a href="#<?php echo $env_id = $error_id.'environment_loaded' ?>" onclick="return koggle('<?php echo $env_id ?>')"><?php echo __('Loaded extensions') ?></a> (<?php echo count($included) ?>)</h3>
			<div id="<?php echo $env_id ?>" class="collapsed">
				<table cellspacing="0">
					<?php foreach ($included as $file): ?>
					<tr>
						<td><code><?php echo Debug::path($file) ?></code></td>
					</tr>
					<?php endforeach ?>
				</table>
			</div>
			<?php foreach (array('_SESSION', '_GET', '_POST', '_FILES', '_COOKIE', '_SERVER') as $var): ?>
			<?php if (empty($GLOBALS[$var]) OR ! is_array($GLOBALS[$var])) continue ?>
			<h3><a href="#<?php echo $env_id = $error_id.'environment'.strtolower($var) ?>" onclick="return koggle('<?php echo $env_id ?>')">$<?php echo $var ?></a></h3>
			<div id="<?php echo $env_id ?>" class="collapsed">
				<table cellspacing="0">
					<?php foreach ($GLOBALS[$var] as $key => $value): ?>
					<tr>
						<td><code><?php echo HTML::chars($key) ?></code></td>
						<td><pre><?php echo Debug::dump($value) ?></pre></td>
					</tr>
					<?php endforeach ?>
				</table>
			</div>
			<?php endforeach ?>
		</div>
	</div>
<?php endif; ?>
	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/webroot/js/jquery/jquery-1.6.2.min.js"></script>
  	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/webroot/js/jquery/jquery-ui-1.8.15.custom.min.js"></script>	  
   	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/webroot/js/fonts/cufon-yui.js"></script>
	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/webroot/js/fonts/Twin_Marker_400.font.js"></script>
	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/webroot/js/app.js"></script>
	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/webroot/js/app.js"></script>
</body>
</html>
