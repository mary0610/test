<?php
	require_once( 'DB.php' );
	require_once( 'T9.php' );
	$T9 = new T9();
?>
<html>
	<head></head>
	<body>
		<form action="" method="post">
			<table>
				<tr>
					<td colspan="3">
						<input type="text" name="search_string" value="<?php echo $T9->search_string; ?>"/>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<?php
						if ( isset ( $_POST['search'] ) ) {
							$users = $T9->search();
							if ( is_array( $users ) ) {
								foreach( $users as $user ) {
									echo '<p>' . $user->name . '  ' . $user->last_name . '  ' .
										$user->phone_number . '</p>';
									}
								} else {
									echo '<p>' . $users . '</p>';
								}
						}
						?>
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="1" name="number" />
					</td>
					<td>
						<input type="submit" value="2" name="number" />
					</td>
					<td>
						<input type="submit" value="3" name="number">
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="4" name="number">
					</td>
					<td>
						<input type="submit" value="5" name="number">
					</td>
					<td>
						<input type="submit" value="6" name="number">
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="7" name="number">
					</td>
					<td>
						<input type="submit" value="8" name="number">
					</td>
					<td>
						<input type="submit" value="9" name="number">
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" name="search" value="Search"/>
					</td>
					<td>
						<input type="submit" name="reset" value="Reset"/>
					</td>
					<td></td>
				</tr>
			</table>
		</form>
	</body>
</html>