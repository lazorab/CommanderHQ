<?php
class NutritionController extends Controller
{
    var $Message;
    
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_COOKIE['UID']))
			header('location: index.php?module=login');	
	}
        
        function TopSelection()
        {
            $Html='';
            if($_REQUEST['topselection'] == 'Zone'){
                $Html='<li>The Zone</li>';
            }else if($_REQUEST['topselection'] == 'Blocks'){
                $Html='<li>Working out your Blocks</li>';
            }else if($_REQUEST['topselection'] == 'Calculator'){
                $Html='<li>Zone Block Calculator</li>';
            }else if($_REQUEST['topselection'] == 'Plan'){
                $Html='<li>Meal Plan</li>';
            }else{           
            $Html='<li>Nutrition</li>';
            }
            return $Html;
        }
	
	function Output()
	{
            if($_REQUEST['content'] == 'Zone'){
                $Html = $this->ZoneContent();
            }else if($_REQUEST['content'] == 'Blocks'){
                $Html = $this->BlocksContent();
            }else if($_REQUEST['content'] == 'Calculator'){
                $Html = $this->Calculator();
            }else if($_REQUEST['content'] == 'Plan'){
                $Html = $this->Plan();
            }else{
             $Html='
                <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getContent(\'Zone\');"><div style="height:26px;width:1px;float:left"></div>The Zone</a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getContent(\'Blocks\');"><div style="height:26px;width:1px;float:left"></div>Working out your Blocks</a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getContent(\'Calculator\');"><div style="height:26px;width:1px;float:left"></div>Zone Block Calculator</a></li>
                <li><a style="font-size:large;margin-top:10px" href="#" onclick="getContent(\'Plan\');"><div style="height:26px;width:1px;float:left"></div>Meal Plan</a></li>                
                </ul><br/>';               
            }
            return $Html;
	}
        
        function ZoneContent()
        {
            $Html = '<h2>Nutrition</h2>
<p>
High on the agenda of any athlete, or anyone training to stay in shape or get in shape is the topic of Nutrition.
</p><p>
The CrossFit philosophy is to follow Barry Sears Zone Diet, which neither prohibits nor requires any particular food. 
</p><p>
It can accommodate Paleo or Vegan, Organic or Kosher, Fast food or fine dining, while delivering the benefits of high performance nutrition.
</p><p>
In The Zone – (ref CrossFit Journal Issue 21)
</p><p>
In the Zone scheme is about understanding what quantity of food you should be consuming to extract the most benefit for achieving your objectives.
</p><p>
This is achieved by defining food into Blocks which is explained further below
</p><p>
In the Zone scheme, all of humanity calculates to either "2", "3", "4", or "5 Block" meals at breakfast, lunch, and dinner with either "1" or "2 block" snacks between lunch and dinner and again between dinner and bedtime. 
</p><p>
What is a Block?
</p><p>
A block is a unit of measure used to simplify the process of making balanced meals.
</p><p>

7 grams of protein = 1block of protein
</p><p>
9 grams of carbohydrate = 1 block of carbohydrate
</p><p>
1.5 grams of fat = 1 block of fat
</p><p>
(Assumption is: that there are about 1.5 grams of fat in each block of protein – the total amount of fat needed per 1 block meal is 3 grams.)
</p><p>
When a meal is composed of equal blocks of protein, carbohydrate, and fat, it is 40 % Carbohydrate, 30% Protein and 30% Fat.
</p><p>
See the list of common foods, their macronutrient category (protein, carbohydrate or fat), along with a conversion of measurements to blocks.
</p><p>
This "block chart" is a convenient tool for making balanced meals. 
</p><p>
1 block meal
</p><p>
Choose: <br/>
1 item of protein <br/>
1 item of carbohydrate<br/>
1 item of fat 
</p><p>
Choose 2 items from each column to compose a 2 Block meal, etc.
</p><p>
4 Block meal <br/>

4 oz. chicken breast<br/>
1 artichoke<br/>
1 cup of steamed vegetables w with 24 crushed peanuts<br/>
1 sliced apple
</p><p>
This meal contains 28 grams of protein, 36 grams of carbohydrate, 12 grams of fat. 
</p><p>
4 blocks of Protein, 4 blocks of Carbohydrate, and 4 blocks of Fat.
</p><p>
We\'ve simplified the process for determining which of the four meal sizes and two snack sizes best suits your needs.
</p><p>
Being a "4 Blocker", means, that you eat 3 meals each day.
Where each meal is comprised of:<br/>
4 blocks of protein<br/>
4 blocks of carbohydrate<br/>
4 blocks of fat.
</p><p>
Whether you are a "smallish" medium sized or "largish" medium sized would determine whether you\'d need snacks of one or two blocks twice a day.
</p><p>
The "meal plans" stand as examples of 2, 3, 4, or 5 block meals and the "block chart" gives quantities of common foods equivalent to 1 block of protein, carbohydrate, or fat.
</p><p>
Once you decide that you need, say, "4 block" meals, it is simple to use the block chart and select four times something from the protein list, four times something from the carbohydrate list, and four times something from the fat list every meal.
</p><p>
One-block snacks are chosen from the block chart at face value for a single snack of protein, carbohydrates, and fat, whereas two block snacks are, naturally, from carbohydrates combined with twice something from the protein list, and twice something from the fats. Every meal, every snack, must contain equivalent blocks of protein, carbohydrate, and fat.
</p><p>
If the protein source is specifically labeled "non-fat", then double the usual fat blocks for that meal. 
</p><p>
Read "Enter the Zone" to learn why. At Zone parameters body fat comes off fast. 
</p><p>
When our men fall below 10% towards 5% we kick up the fat intake. 
</p><p>
The majority of CrossFit\'s best athletes end up at X blocks of protein, X blocks of carbohydrate, and 4X or 5X blocks of fat. 
</p><p>
Learn to modulate fat intake to a level of leanness that optimizes performance.
<p/>
<br/>';
            
            return $Html;
        }
        
        function BlocksContent()
        {
            $Html='Coming Soon!';
            return $Html;
        }
        
        function Calculator()
        {
            $Html='Coming Soon!';
            return $Html;           
        }
        
        function Plan()
        {
            $Html='Coming Soon!';
            return $Html;            
        }
}
?>