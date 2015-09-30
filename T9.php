<?php
error_reporting( E_ALL | E_STRICT  );

/**
 * Class T9 describes the basic functionaly and T9 algorythm of search.
 * Since it was not possible to use javascript and css, I restricted the input to 4 symbols.
 */
class T9 {

	public $keyboard, $number, $search_string;

	/**
	 * contains all necessary variables, and calls of all functions in order to avoid their calls in
	 * other places
	 */
	function __construct() {
		$this->number = $_POST['number'];
		$this->search_string = $_POST['search_string'];
		$this->keyboard = array(
			2 => array( 'a', 'b', 'c' ),
			3 => array( 'd', 'e', 'f' ),
			4 => array( 'g', 'h', 'i' ),
			5 => array( 'j', 'k', 'l' ),
			6 => array( 'm', 'n', 'o' ),
			7 => array( 'p', 'q', 'r', 's' ),
			8 => array( 't', 'u', 'v' ),
			9 => array( 'w', 'x', 'y', 'z' )
		);

		if ( isset( $_POST['number'] ) ) {
			$this->getSearchSting();
		}

		if ( isset ( $_POST['reset'] ) ) {
			$this->resetInput();
		}
	}

	/**
	 * forms array of the letters combinations according to T9 algorithm
	 * @return array of letters combination
	 */
	private function t9_search() {
		if ( isset($_POST['search'] ) ) {
			/**
			 * this is our input string, split into separate digits
			 */
			$search = array_map( 'intval', str_split( $this->search_string ) );
			$varNumber = array();
			/**
			 * finding out how many combinations of letters we have in total
			 */
			foreach ( $search as $key => $value ) {
				$varNumber[] = array_product( $varNumber ) * count( $this->keyboard[$value] );
			}

			$letterCombinations = array();

			foreach( $search as $key => $digit ) {
				$letterIndex = 0;
				$curLetter  = count( $search ) - ( $key + ( count($search) - 1 ) );
				$changed = 0;

				/**
				 * $curLetter is a sticker, the first letter in the combination
				 * to which we stick other letters
				 */
				for ( $i = 0; $i < max( $varNumber ); $i++ ) {
					$letterCombinations[$i] .= $this->keyboard[$search[$key]][$letterIndex];
					if ( $curLetter >= 0 && $i == ( $varNumber[$curLetter] * ( $changed + 1 ) ) - 1 || $curLetter < 0 ) {
						$changed ++;
						if ( $letterIndex < count( $this->keyboard[$search[$key]] ) - 1 ) {
							$letterIndex ++;
						} else {
							$letterIndex = 0;
						}
					}
				}
			}
		}
		/**
		 * unfortunately, the array has duplicates, we need to get rid of them
		 */
		return array_unique( $letterCombinations );
	}

	/**
	 * makes query to the database to find users
	 * @return array|string
	 */
	public function search() {
		$whatToSearch = $this->t9_search();
		$db = DB::getInstance();
		$users = array();
		foreach( $whatToSearch as $letters ) {
			$letters = ucwords($letters);
			$result = $db->query('SELECT * from phone_book where MATCH (name, last_name) AGAINST
			("' . $letters . '*" IN BOOLEAN MODE) limit 0, 100');
			if ( ! $result ) continue;
			$users[] = $result;
		}
		return count( $users ) > 0 ? $users : 'No users found';
	}

	/**
	 * since it's not allowed to use javascript or any other things, this function makes a little
	 * trick with filling in the field with digits, it sticks digits and we display it then in the
	 * field. This is kind of imitation of beautiful user interface with the handy buttons :-)
	 */
	public function getSearchSting() {
		/** let us restrict input to 4 digits */
		if ( strlen( $this->search_string ) < 4 ) {
			$this->search_string = $this->search_string . $this->number;
		}
	}

	/**
	 * this is simple: we get rid of the digits that we had before
	 */
	public function resetInput() {
		$this->search_string = '';
	}
}
