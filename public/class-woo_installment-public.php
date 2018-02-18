<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Woo_Installment
 * @subpackage Woo_Installment/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Installment
 * @subpackage Woo_Installment/public
 * @author     Your Name <email@example.com>
 */
class Woo_Installment_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Woo_Installment    The ID of this plugin.
	 */
	private $Woo_Installment;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Woo_Installment       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Woo_Installment, $version ) {

		$this->Woo_Installment = $Woo_Installment;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Installment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Installment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Woo_Installment, plugin_dir_url( __FILE__ ) . 'css/woo_installment-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Installment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Installment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_script( $this->Woo_Installment, plugin_dir_url( __FILE__ ) . 'js/woo_installment-public.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->Woo_Installment, plugin_dir_url( __FILE__ ) . 'js/angular.min.js', array( 'jquery' ), $this->version, false );



		/**
		 * This function is provided for real work .
		 *
		 
		 */
if ( ! function_exists( 'installment_warp' ) ) {           
    function installment_warp() {
        global $product;
       
        $response = wp_remote_get( plugin_dir_url( __FILE__ ).'/a.json' );
        $resBody = wp_remote_retrieve_body( $response );
       
        $gitcatname= $product->get_categories();
        echo $gitcatname;

        ?>

    <button type="button" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" id="instalment" class="single_add_to_cart_button button alt instalment"
        onclick="document.getElementById('installment_table').style.visibility='visible'">
        <?php echo 'Installment';?>>
    </button>

    <div id="installment_table" class="alert alert-success">
        <br>
        <strong>
            <?php print('Installment Bar')?>
        </strong>
        <?php print('Installment is OK')?>.
        <?php  
        global $product;
       ?>
        <p class="price">
            <?php echo $product->get_price_html(); ?>
        </p>
        <?php
        echo $product->price ;
        ?>
             <div ng-app="installment">
                <div ng-controller="ctrl">

                    <div class="input-group input-group-lg">
                        <!--<span class="input-group-addon" id="sizing-addon1">@</span>-->
                        <p>Input something in the input box:</p>
                        <input type="text" ng-model="inAdvance" class="form-control" placeholder="المقدم" aria-describedby="sizing-addon1">
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">
                            اختار مدة القسط
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li ng-repeat="dur in body.durs">
                                <a ng-click="do($index)" href="">{{dur.monthes}} monthes</a>
                            </li>
                            <!--<li role="separator" class="divider"></li>-->
                            <!--<li><a href="#">Separated link</a></li>-->
                        </ul>
                    </div>
                    
                    <!--<p>Name: <input type="text"></p>-->
                    <p>the rest price : {{body.restprice}}</p>
                    <p>interest : {{body.interest}}</p>
                    <p>each month : {{body.eachMonth}}</p>


                    <div class="alert alert-warning" ng-show="showAlert">
                        <strong>تحزير!</strong> برجاء ادخال مبلغ اكبر من او يساوى 20% من المبلغ الاصلى.
                    </div>

                </div>
<script>
angular.module("installment", []).controller('ctrl', function ($scope) {

console.log(<?php echo json_encode($resBody) ?>);
$scope.price = parseInt(<?php echo json_encode($product->price) ?>);
$scope.body = JSON.parse(<?php echo json_encode($resBody) ?>);

/*{

/*  equated monthly installment (EMI)  
A fixed payment amount made by a borrower to a lender at a specified date each calendar month.

where:  P is the principal amount borrowed, 
A is the periodic amortization payment, 
r is the periodic interest rate divided by 100 (annual interest rate also divided by 12 in case of monthly installments), 
and n is the total number of payments
P هو المبلغ الرئيسي المقترض،
                    A هو دفع الإطفاء الدوري،
                    r هو سعر الفائدة الدوري مقسوما على 100 (سعر الفائدة السنوي مقسوما أيضا على 12 في حالة الأقساط الشهرية)
                    n هو إجمالي عدد المدفوعات ال شهرية
For example,
if you borrow 10,000,000 units of a currency from the bank at 10.5% annual interest for a period of 10 years (i.e., 120 months), 
then EMI = Units of currency 10,000,000 * 0.00875 * (1 + 0.00875)^120 / ((1 + 0.00875)^120 – 1) = Units of currency 134,935. i.e., 
you will have to pay total currency units 134,935 for 120 months to repay the entire loan amount. 
The total amount payable will be 134,935 * 120 = 16,192,200 currency units that includes currency units 6,192,200 as interest toward the loan.
*/
// the formula...
//EMI = p * r * (1 + r)^n / ((1 + r)^n – 1) = Units of currency 
// المعلومات المتوفرة
//السعر الكامل 
//P باقى المبلغ (المقسط)
//r هو سعر الفائدة الدوري مقسوما على 100  ثم على 12 باشهر 
//n هو إجمالي عدد المدفوعات ال شهرية
// المعلومة المطلوبة
//A مبلغ القسط

// تعديل المعادلة لتصبح قابلة للحساب بالكمبيوتر و تقسيم عمليلا الحساب
//EMI = p * (r * (1 + r)^n / ((1 + r)^n – 1)) = Units of currency 
// تقسيم العملية و اضافة ال  JavaScript Math Opject

//EMI A = p * ((r * (Math.pow(1 + r, n)) / ((Math.pow(1 + r, n) – 1))) = Units of currency 
//تسمية المتغيرات


///////////////////////////////////////////////////////////////////////////////
//A = p * ((r * (Math.pow(1 + r, n)) / ((Math.pow(1 + r, n) – 1))) = Units of currency
//A = periodicAmortizationPayment
//p = principalAmountBorrowed
//r = periodicInterestRateDivided
//n = totalNumberOfPayments
//periodicAmortizationPayment = principalAmountBorrowed * ((periodicInterestRateDivided * (Math.pow((1 + periodicInterestRateDivided), totalNumberOfPayments)) / ((Math.pow((1 + periodicInterestRateDivided), totalNumberOfPayments) – 1))) = Units of currency
////////////////////////////////////////////////////////////////////////////////

//loanNetCost = (principal) + (loanTotalInterest);
//alert('You will owe this much money: + loanNetCost');



//استخلاص دفعة الاستهلاك الدورية 

var principalAmountBorrowed = $scope.principalAmountBorrowed;
var periodicInterestRateDivided = $scope.periodicInterestRateDivided;
var totalNumberOfPayments = $scope.totalNumberOfPayments;
$scope.periodicAmortizationPayment = () => {

    principalAmountBorrowed * ((periodicInterestRateDivided * (Math.pow((1 + periodicInterestRateDivided), totalNumberOfPayments)) / ((Math.pow((1 + periodicInterestRateDivided), totalNumberOfPayments) - 1))));
    
};
console.log($scope);
$scope.do = (idx) => {
    

// استخلاص نسبة ال فائدة
$scope.rate =  $scope.body.categs[0].installmentDuration[0]

//استخلاص نسبة المؤخر سدادة
$scope.p = $scope.price - $scope.inAdvance;
 
//استخلاص نسبة الفائدة على كل شهر 
$scope.r = ($scope.rate / 100) / 12;


//$scope.totalNumberOfPayments = $scope.inAdvance;

//استخلاص شهور الدفع
$scope.n = $scope.body.durs[0].monthes;
    
///////////////////////////////////////////////////////////////////////////////
//A = p * ((r * (Math.pow(1 + r, n)) / ((Math.pow(1 + r, n) – 1))) = Units of currency
//A = periodicAmortizationPayment
//p = principalAmountBorrowed
//r = periodicInterestRateDivided
//n = totalNumberOfPayments
//periodicAmortizationPayment = principalAmountBorrowed * ((periodicInterestRateDivided * (Math.pow((1 + periodicInterestRateDivided), totalNumberOfPayments)) / ((Math.pow((1 + periodicInterestRateDivided), totalNumberOfPayments) – 1))) = Units of currency
////////////////////////////////////////////////////////////////////////////////
    $scope.A =  $scope.p * (( $scope.r * (Math.pow(1 +  $scope.r,  $scope.n)) / ((Math.pow(1 +  $scope.r,  $scope.n) - 1))));   

   console.log(idx);
   
    if ($scope.inAdvance > 0.2 * $scope.price && $scope.inAdvance < $scope.price) {
    $scope.showAlert = false;
    $scope.body.restprice = $scope.p    
    $scope.body.interest = $scope.rate
    $scope.body.eachMonth = $scope.A
    console.log("do or RUN Function");
    
} else {
    $scope.showAlert = true;
    console.log($scope);
    console.log("dd");
    
}   
}

console.log($scope);
});
</script>
            </div>


    </div>
    </div>
    <!-- /.single-product-installment-wrapper -->
    <script>
        document.getElementById('installment_table').style.visibility = 'hiddin'
    </script>
    <?php
            }
        }

add_action( 'woocommerce_after_add_to_cart_button',		'installment_warp',	 	1  );








function wporg_options_page()
{
    add_menu_page(
        'Installment Rawash Plugin',
        'installment Options',
        'manage_options',
        'installment',
        'wporg_options_page_html',
        plugin_dir_url(__FILE__) . 'images/icon_wporg.png',
        20
    );
}
add_action('admin_menu', 'wporg_options_page');


function wporg_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
            <?php
            
            echo "Instalment Option Page ";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<body ng-app="installment">

    <div ng-controller="ctrl">

        <div class="col-md-3 col-xs-6" ng-repeat="categ in categs">
            <h2>{{categ.type}}</h2>
            <div class="row" ng-repeat="dur in durs">
                <div class="col-xs-12 input-group input-group-lg">
                    <span class="input-group-addon" id="sizing-addon1">{{dur.monthes}} monthes </span>
                    <input type="text" ng-model="categ.installmentDuration[$index]" class="form-control" placeholder="">
                </div>
            </div>

        </div>

        <button class="btn btn-default dropdown-toggle" ng-click="print()" type="button" id="dropdownMenu1" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="true">

            <div class="alert alert-warning" ng-show="showAlert">
                <strong>تحزير!</strong> برجاء ادخال مبلغ اكبر من او يساوى 20% من المبلغ الاصلى.
            </div>

    </div>
    <script>
        angular.module('installment', [])
            .controller('ctrl', function ($scope) {
                $scope.per = 0;
                $scope.eachMonth = 0
                $scope.interest = 0
                $scope.restAmount = 0
                $scope.showAlert = false;
                ///////////////////////////////////////////////////////////
                $scope.durs = [{
                    monthes: 6,
                }, {
                    monthes: 12,
                }, {
                    monthes: 24,
                }]

                $scope.categs = [{
                        type: "air caonditaner",
                        installmentDuration: [0.25, 0.35]
                    },
                    {
                        type: "phones",
                        installmentDuration: [0.25, 0.35]
                    }
                ]

                //////////////////////////////////////////////////////////////////////////////////////////////////
                $scope.print = () => {
                    console.log($scope.categs)
                }

                $scope.getper = (idx) => {
                    $scope.per = $scope.categs[0].installmentDuration[idx]
                    $scope.monthes = $scope.durs[idx].monthes
                    let amount = 5000;
                    if ($scope.inAdvance > 0.2 * amount && $scope.inAdvance < amount) {
                        $scope.showAlert = false;

                        $scope.restAmount = amount - $scope.inAdvance
                        $scope.interest = $scope.restAmount * $scope.per
                        $scope.eachMonth = ($scope.restAmount + $scope.interest) / $scope.monthes
                    } else {
                        $scope.showAlert = true;
                    }
                }

            });
    </script>installmentrate
</body>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}


/* function wporg_options_page_html()
{
 */    // check user capabilities*/
	}

}
