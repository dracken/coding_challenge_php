<?php 
/**
 *  Convert a Number to a String
 * 
 *  @author Derek Boerger
 *  @since Oct 2018
 *  @version 1.0
 *  
 *  Take a numeric value and convert it to its string equivalent
 */

class num2string
{
    /**
     * Define variables
     */
    protected $number;
    protected $split_number = [];
    protected $whole = []; //['decillion', 'nonillion', 'octillion', 'septillion', 'sextillion', 'quintillion', 'quadrillion', 'trillion', 'billion', 'million', 'thousand', 'hundred'];
    protected $fraction;
    
    protected $debug_output = "";
    
    public $output = "";
    
    /**
     * Default Construct
     * 
     * @param string $number
     */
    public function __construct(string $number)
    {
        $this->number = $number;
        $this->run($this->number);
    }
    
    /**
     * Run
     * 
     * Runs the application
     * 
     * @param string $number
     * @throws exception
     * @return boolean
     */
    public function run(string $number)
    {
        try {
            $this->check_num($number);
        }
        catch (exception $e){
            $this->output = $e->getMessage();
            return false;
        }
        
        $this->split_number = $this->num_split($number);
        $this->fraction = $this->get_fraction($this->split_number['fraction']);
        
        try{
            $this->whole = $this->parse_whole($this->split_number['whole']);
        }
        catch (exception $e){
            $this->output = $e->getMessage();
            return false;
        }
        
        $this->output = $this->display($this->whole, $this->fraction);
        return true;
    }
    
    /**
     * Check Num
     * 
     * Checks to ensure that the passed value is a US numeric value
     * 
     * @param string $number
     * @throws exception
     * @return integer
     */
    private function check_num(string $number)
    {
        if (is_numeric(str_replace(",", "", $number)))
        {
            return $number;
        }
        else
        {
            throw new exception("Value <i>$number</i> is not numeric.<br>\n");
        }
    }
    
    /**
     * Num Split
     * 
     * Takes the input number and splits it, both in whole and fraction components and then the whole in reversed 3 numeric bundles
     * 
     * @example 123,456,789 converts to Array ( [0] => 789 [1] => 456 [2] => 123 ) 
     * 
     * @param string $number
     * @return array
     */
    private function num_split(string $number)
    {
        $return_array = [];
          
        $number_stripped = str_replace(",", "", $number);
        
        $number_explode = explode(".", $number_stripped, 2);
        
        $return_array['whole'] = str_split(strrev($number_explode[0]), 3);  
        krsort($return_array['whole']);
        
        $return_array['fraction'] = isset($number_explode[1]) ? $number_explode[1] : "0";
        
        return $return_array;
    }
    
    /**
     * Get Fraction
     * 
     * Get the fractional value in hundreths
     * 
     * @param int $fraction
     * @return string
     */
    private function get_fraction(int $fraction)
    {
        if (strlen($fraction) < 2)
        {
            $fraction = "0".$fraction;
        }
        
        return "$fraction/100";
    }
    
    /**
     * Parse Whole Number
     * 
     * Parse the whole number up to 36 digits
     * 
     * @param array $whole
     * @return string
     */
    private function parse_whole(array $number)
    {
        if (count($number) > 12) // Number is too big, throw an error
        {
            throw new exception("Error: Number $this->number is too big to process.");
        }
        
        for($i = count($number) - 1; $i >= 0; $i--)
        {
            $number[$i] = str_pad(strrev($number[$i]), 3, "0", STR_PAD_LEFT);
            
            switch ($i)
            {
                default:          
                case "0": //hundreds
                    $this->whole['hundred'] = $this->convert_hundreds_number($number[$i]);
                break;
                
                case "1": //thousands
                    $this->whole['thousand'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." thousand" : NULL;
                break;
                
                case "2": //millions
                    $this->whole['million'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." million" : NULL;
                break;
                
                case "3": //billions
                    $this->whole['billion'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." billion" : NULL;
                break;
                
                case "4": //trillions
                    $this->whole['trillion'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." trillion" : NULL;
                break;
                
                case "5": //quadrillion
                    $this->whole['quadrillion'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." quadrillion" : NULL;
                break;
                
                case "6": //quintillion
                    $this->whole['quintillion'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." quintillion" : NULL;
                break;
                
                case "7": //sextillion
                    $this->whole['sextillion'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." sextillion" : NULL;
                break;
                
                case "8": //septillion
                    $this->whole['septillion'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." septillion" : NULL;
                break;
                
                case "9": //octillion
                    $this->whole['octillion'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." octillion" : NULL;
                break;
                
                case "10": //nonillion
                    $this->whole['nonillion'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." nonillion" : NULL;
                break;
                
                case "11": //decillion
                    $this->whole['decillion'] = $number[$i] != "000" ? $this->convert_hundreds_number($number[$i])." decillion" : NULL;
                break;
                    
            }
        }
        return $this->whole;
    }
    
    /**
     * Convert Single Number
     * 
     * convert a single numeric number from a digit to a string
     * 
     * @param int $number
     * @return string
     */
    private function convert_ones_number(int $number)
    {
        switch ($number)
        {
            case "0":
                return "zero";
            break;
            
            case "1":
                return "one";
            break;
            
            case "2":
                return "two";
            break;
            
            case "3":
                return "three";
            break;
            
            case "4":
                return "four";
            break;
            
            case "5":
                return "five";
            break;
            
            case "6":
                return "six";
            break;
            
            case "7":
                return "seven";
            break;
            
            case "8":
                return "eight";
            break;
            
            case "9":
                return "nine";
            break;
        }
    }
    
    /**
     * Convert tens number
     * 
     * Converts any two digit number into a tens value, keeping in mind the special cases for teens and values divisible by 10
     * 
     * @param string|int $number
     * @return void|string
     */
    private function convert_tens_number(string $number)
    {
        //$number = str_pad($number, 2, "0", STR_PAD_LEFT);
        $number = str_split($number);
        
        //beginning value of number is zero and ending is non-zero
        if ($number[0] == "0" && $number[1] != "0")
        {
            return $this->convert_ones_number($number[1]);
        }
        
        //ending value of number is zero
        elseif ($number[1] == "0" && $number[0] != "0")
        {
            switch ($number[0])
            {
                case "1":
                    return "ten";
                break;
                
                case "2":
                    return "twenty";
                break;
                
                case "3":
                    return "thirty";
                break;
                
                case "4":
                    return "fourty";
                break;
                
                case "5":
                    return "fifty";
                break;
                
                case "6":
                    return "sixty";
                break;
                
                case "7":
                    return "seventy";
                break;
                
                case "8":
                    return "eighty";
                break;
                
                case "9":
                    return "ninty";
                break;
            }
        }
        //beginning number value is 1, i.e. teens
        elseif ($number[0] == "1" && $number[1] != "0")
        {
            switch($number[1])
            {
                case "1":
                    return "eleven";
                break;
                
                case "2":
                    return "twelve";
                break;
                
                case "3":
                    return "thirteen";
                break;
                
                case "4":
                    return "fourteen";
                return;
                
                case "5":
                    return "fifteen";
                return;
                
                case "6":
                    return "sixteen";
                break;
                
                case "7":
                    return "seventeen";
                break;
                
                case "8":
                    return "eighteen";
                break;
                
                case "9":
                    return "nineteen";
                break;
            }
        }
        // number is greater than 20 and not divisible by 10
        elseif ($number[0] > 1 && $number[1] != 0)
        {
            $convert_ones = $this->convert_ones_number($number[1]);
            
            switch($number[0])
            {
                case "2":
                    return "twenty-".$convert_ones;
                break;
                
                case "3":
                    return "thirty-".$convert_ones;
                break;
                
                case "4":
                    return "fourty-".$convert_ones;
                break;
                
                case "5":
                    return "fifty-".$convert_ones;
                break;
                
                case "6":
                    return "sixty-".$convert_ones;
                break;
                
                case "7":
                    return "seventy-".$convert_ones;
                break;
                
                case "8":
                    return "eighty-".$convert_ones;
                break;
                
                case "9":
                    return "ninty-".$convert_ones;
                break;
            }
        }
    }
    
    /**
     * Convert hundreds
     * 
     * Convert any three number value into a hundreds value
     * 
     * @param string $number
     * @return string
     */
    private function convert_hundreds_number(string $number)
    { 
        $number = str_split($number);
        
        switch ($number[0])
        {
            case "0":
                $convert_hundreds = "";
            break;
            
            default:
                $convert_hundreds = $this->convert_ones_number($number[0]) . " hundred";
            break;
                
        }
        
        $tens = $number[1].$number[2];
        
        $convert_tens = $this->convert_tens_number($tens);
        
        return $convert_hundreds." ".$convert_tens;
    }
    
    /**
     * Display
     * 
     * Parses the two sides of the number whole and fraction into the word value
     * 
     * @param array $whole
     * @param string $fraction
     */
    private function display($whole, $fraction)
    {
        $whole_words = "";
        foreach ($whole as $value)
        {
          if (!is_null($value))
          {
              $whole_words .= $value ." ";
          }
        }
        
        return "Number <i>'$this->number'</i> reads as " . $whole_words." and ".$fraction."<br>\n";
    }
}
?>