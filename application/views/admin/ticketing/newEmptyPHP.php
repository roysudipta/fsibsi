<?php
/**
 * Plugin Name: Product Import
 * Plugin URI: http://xodmedia.com/
 * Description: Product Import
 * Version: 1.0
 * Author: xodmedia.com
 * Author URI: http://xodmedia.com/
 */
require_once 'excel_reader2.php';

function add_custom_product_import() {
    add_menu_page('Manage Product', 'Add Inventory Master', 10, __FILE__, 'add_inventory_master');
//        add_submenu_page(__FILE__, 'Add', 'Add Inventory Master', 10,'add_inventory_master', 'add_inventory_master');
    add_submenu_page(__FILE__, 'Add', 'Add Nutritional Info', 10, 'add_nutritional_info', 'add_nutritional_info');
}

function create_stats_product_import() {
    global $wpdb;
    //create the name of the table including the wordpress prefix (wp_ etc)
    $search_table = $wpdb->prefix . "inventory_master";
    $search_table1 = $wpdb->prefix . "nutritional_info";
    //$wpdb->show_errors();
    //check if there are any tables of that name already
    if (($wpdb->get_var("show tables like '$search_table'") !== $search_table) && ($wpdb->get_var("show tables like '$search_table1'") !== $search_table1)) {
        //create your sql
        $sql = "CREATE TABLE " . $search_table . " (
                inventory_id int(11) NOT NULL AUTO_INCREMENT,
                stock_code VARCHAR(255) NOT NULL,
                product_class_description VARCHAR(255) NOT NULL,                            
                product_name_en VARCHAR(255) NOT NULL,
                product_name_fr VARCHAR(255) NOT NULL,                            
                shelflife VARCHAR(255) NOT NULL,                            
                category_description  text NOT NULL,
                category_group_description  text NOT NULL,                            
                line_of_bussiness_description  text NOT NULL,                            
                scccode VARCHAR(255) NOT NULL,                            
                upccode VARCHAR(255) NOT NULL,                            
                packinfo2 VARCHAR(255) NOT NULL,                            
                length_case VARCHAR(255) NOT NULL,
                length_uom_case VARCHAR(255) NOT NULL,
                width_case VARCHAR(255) NOT NULL,
                width_uom_case VARCHAR(255) NOT NULL,
                height_case VARCHAR(255) NOT NULL,
                height_uom_case VARCHAR(255) NOT NULL,                            
                pallet_tie VARCHAR(255) NOT NULL, 
                pallet_tier VARCHAR(255) NOT NULL,                            
                gross_weigth VARCHAR(255) NOT NULL,                            
                sizeplusuom VARCHAR(255) NOT NULL,                            
                ingredients_en longtext NOT NULL,
                ingredients_fr longtext NOT NULL,                            
                gen_description_en text NOT NULL,
                gen_description_fr text NOT NULL,                            
                kosher_list VARCHAR(255) NOT NULL,                            
                image_name VARCHAR(255) NOT NULL,                              
                category_slug VARCHAR(255) NOT NULL,                            
                subcategory_slug VARCHAR(255) NOT NULL,                            
                product_slug VARCHAR(255) NOT NULL,
                creation_date datetime NOT NULL,
                modification_date datetime NOT NULL,
                PRIMARY KEY (inventory_id))";

        $sql1 = "CREATE TABLE " . $search_table1 . " (
                nutritional_info_id int(11) NOT NULL AUTO_INCREMENT,
                stock_code VARCHAR(255) NOT NULL,
                stock_code_description text NOT NULL,
                serving_size VARCHAR(255) NOT NULL,
                serving_size_uom  VARCHAR(255) NOT NULL,
                prepared_serving VARCHAR(255) NOT NULL,
                prepared_serving_uom  VARCHAR(255) NOT NULL,
                energy   VARCHAR(255) NOT NULL,
                total_fat VARCHAR(255) NOT NULL,
                rdi_total_fat VARCHAR(255) NOT NULL,
                saturated_fat VARCHAR(255) NOT NULL,
                trans_fatty_acids VARCHAR(255) NOT NULL,
                rdi_saturated_trans_fatty_acids  VARCHAR(255) NOT NULL,
                cholesterol VARCHAR(255) NOT NULL,
                sodium  VARCHAR(255) NOT NULL,
                rdi_sodium   VARCHAR(255) NOT NULL,
                carbohydrate  VARCHAR(255) NOT NULL,
                rdi_carbohydrate  VARCHAR(255) NOT NULL,
                fibre  VARCHAR(255) NOT NULL,
                rdi_fibre  VARCHAR(255) NOT NULL,
                sugar  VARCHAR(255) NOT NULL,
                protein  VARCHAR(255) NOT NULL,
                vitamin_a  VARCHAR(255) NOT NULL,
                vitamin_c  VARCHAR(255) NOT NULL,
                calcium  VARCHAR(255) NOT NULL,
                iron  VARCHAR(255) NOT NULL,
                sucralose  VARCHAR(255) NOT NULL,
                aspartame VARCHAR(255) NOT NULL,
                nutritional_information VARCHAR(255) NOT NULL,
                creation_date datetime NOT NULL,
                PRIMARY KEY (nutritional_info_id))";
    }
    //include the wordpress db functions
    require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
    dbDelta($sql);
    dbDelta($sql1);
    //register the new table with the wpdb object
    if (!isset($wpdb->stats)) {
        $wpdb->stats = $search_table;
        $wpdb->tables[] = str_replace($wpdb->prefix, '', $search_table);
        $wpdb->stats1 = $search_table1;
        $wpdb->tables[] = str_replace($wpdb->prefix, '', $search_table1);
    }
}

function uninstall_product_import() {
    global $wpdb;
    $search_table = $wpdb->prefix . "inventory_master";
    $search_table1 = $wpdb->prefix . "nutritional_info";
    //$query="drop table $search_table";
    // $query1="drop table $search_table1";
    $wpdb->query($query);
    $wpdb->query($query1);
//        $dir = ABSPATH."wp-content/uploads/import";
//        $dir_img = ABSPATH."wp-content/uploads/doctors_image";
//        recursiveRemoveDirectory($dir);
//        recursiveRemoveDirectory($dir_img);
}

register_activation_hook(__FILE__, 'create_stats_product_import');
register_Deactivation_hook(__FILE__, 'uninstall_product_import');
//add_action('init', 'create_stats_product_import');
add_action('admin_menu', 'add_custom_product_import');

// for data uploading of inventory master table start
function add_inventory_master() {
    global $wpdb;

    $error = '';
    $success = '';
    if (isset($_POST["Import"])) {
        $filename = rand(2, 1000) . '_' . $_FILES['file']['name'];
        $fileextension = explode(".", $filename);
        $fileextension = end($fileextension);
        if ($fileextension == 'xls') {

            $product_table = $wpdb->prefix . "inventory_master";
            $sql_truncate = "TRUNCATE TABLE wp_inventory_master";
            $wpdb->query($sql_truncate);

            //mysql_query($sql_truncate) or die(mysql_error());
//            exit;
            move_uploaded_file($_FILES['file']['tmp_name'], ABSPATH . "/wp-content/plugins/product_import/excel_file/" . $filename);
            $data = new Spreadsheet_Excel_Reader(ABSPATH . "/wp-content/plugins/product_import/excel_file/" . $filename);


            if ($_FILES["file"]["size"] > 0) {
                for ($i = 0; $i < count($data->sheets); $i++) {
                    if (count($data->sheets[$i][cells]) > 0) {
                        for ($j = 2; $j <= count($data->sheets[$i][cells]); $j++) {

                            $data->sheets[$i][cells][$j][1];
                            $stock_code = trim($data->sheets[$i][cells][$j][1]);
                            $product_class_description = trim($data->sheets[$i][cells][$j][2]);
                            $product_name_en = utf8_encode($data->sheets[$i][cells][$j][3]);
                            $product_name_fr = utf8_encode($data->sheets[$i][cells][$j][4]);
                            $shelflife = trim(esc_sql($data->sheets[$i][cells][$j][5]));
                            $category_description = trim($data->sheets[$i][cells][$j][6]);
                            $category_group_description = trim($data->sheets[$i][cells][$j][7]);
                            $line_of_bussiness_description = trim($data->sheets[$i][cells][$j][8]);
                            $scccode = trim($data->sheets[$i][cells][$j][9]);
                            $upccode = trim($data->sheets[$i][cells][$j][10]);
                            $packinfo2 = trim($data->sheets[$i][cells][$j][11]);
                            $length_case = trim($data->sheets[$i][cells][$j][12]);
                            $length_uom_case = trim($data->sheets[$i][cells][$j][13]);
                            $width_case = trim($data->sheets[$i][cells][$j][14]);
                            $width_uom_case = trim($data->sheets[$i][cells][$j][15]);
                            $height_case = trim($data->sheets[$i][cells][$j][16]);
                            $height_uom_case = trim($data->sheets[$i][cells][$j][17]);
                            $pallet_tie = trim($data->sheets[$i][cells][$j][18]);
                            $pallet_tier = trim($data->sheets[$i][cells][$j][19]);
                            $gross_weigth = trim($data->sheets[$i][cells][$j][20]);
                            $sizeplusuom = trim($data->sheets[$i][cells][$j][21]);
                            //$ingredients_en =utf8_encode($data->sheets[$i][cells][$j][22])."®™";
                            if (strpos($data->sheets[$i][cells][$j][22], "®™") != false) {
                                $ingredients_en = $data->sheets[$i][cells][$j][22];
                            } else if (strpos($data->sheets[$i][cells][$j][22], "®") != false) {
                                $ingredients_en = $data->sheets[$i][cells][$j][22];
                            } else if (strpos($data->sheets[$i][cells][$j][22], "©") != false) {
                                $ingredients_en = $data->sheets[$i][cells][$j][22];
                            } else if (strpos($data->sheets[$i][cells][$j][22], "™") != false) {
                                $ingredients_en = $data->sheets[$i][cells][$j][22];
                            } else {
                                $ingredients_en = utf8_encode($data->sheets[$i][cells][$j][22]);
                            }

                            if (strpos($data->sheets[$i][cells][$j][23], "®™") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "®") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "©") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "™") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "d’orange concentré") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "fécule") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "maïs") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "mélange") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "Matière") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "sèche") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "végétales") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "hydrogénée") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "concentré") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else if (strpos($data->sheets[$i][cells][$j][23], "préparée") != false) {
                                $ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            } else {
                                $ingredients_fr = addslashes(utf8_encode(esc_sql($data->sheets[$i][cells][$j][23])));
                            }

                            $Preparation_And_Cooking_Suggestions_EN = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][28])));
                            $Preparation_And_Cooking_Suggestions_FR = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][29])));
                            $Serving_Suggestions_EN = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][30])));
                            $Serving_Suggestions_FR = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][31])));
                            //$Serving_Suggestions_FR="test";
                            $YieldPerUnit = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][33])));
                            $YieldPerUnitUom = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][34])));
                            $Serving_Size = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][35])));
                            $Serving_Size_UOM = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][36])));
                            $NumServings = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][37])));
                            $Healthy = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][32])));
                            $Volume_Case = trim($data->sheets[$i][cells][$j][41]);
                            $Volume_CuFt = trim($data->sheets[$i][cells][$j][42]);
                            $GlutenFree = trim($data->sheets[$i][cells][$j][43]);
                            //$ingredients_fr = esc_sql($data->sheets[$i][cells][$j][23]);
                            //$ingredients_en = $data->sheets[$i][cells][$j][22];
                            //$ingredients_fr = utf8_encode(esc_sql($data->sheets[$i][cells][$j][23]));
                            //$gen_description_en = utf8_encode(esc_sql($data->sheets[$i][cells][$j][24]));
                            //$gen_description_fr = utf8_encode(esc_sql($data->sheets[$i][cells][$j][25]));
                            $gen_description_en = $data->sheets[$i][cells][$j][24];
                            $gen_description_fr = addslashes(utf8_encode($data->sheets[$i][cells][$j][25]));
                            $kosher_list = trim($data->sheets[$i][cells][$j][26]);
                            $image_name = trim($data->sheets[$i][cells][$j][27]);

                            $category_slug = trim($data->sheets[$i][cells][$j][7]);
                            
                            $For_More_Information_EN  = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][39])));
                            $For_More_Information_FR = addslashes(utf8_encode(trim($data->sheets[$i][cells][$j][40])));

                            $category_slug = trim(strtolower($category_slug));
                            $category_slug = html_entity_decode($category_slug);
                            $category_slug = str_replace('.', '-', $category_slug);
                            $category_slug = str_replace(array('ä', 'ü', 'ö', 'ß'), array('ae', 'ue', 'oe', 'ss'), $category_slug);
                            $category_slug = preg_replace('~[^\\pL\d.]+~u', '-', $category_slug);
                            $category_slug = preg_replace('#[\s]{2,}#', ' ', $category_slug);
                            $category_slug = str_replace(array(' '), array('-'), $category_slug);
                            $category_slug = trim($category_slug, '-');

//                        $subcategory_slug = trim(strtolower($subcategory_name));
//                        $subcategory_slug = html_entity_decode($subcategory_slug);
//                        $subcategory_slug = str_replace('.','-',$subcategory_slug);
//                        $subcategory_slug = str_replace(array(INSERT INTO wp_inventory_master (`stock_code`, `product_class_description`, `product_name_en`, `product_name_fr`,`shelflife`, `category_description`, `category_group_description`, `line_of_bussiness_description`, `scccode`, `upccode`, `packinfo2`, `length_case`, `length_uom_case`, `width_case`, `width_uom_case`, `height_case`, `height_uom_case`, `pallet_tie`, `pallet_tier`, `gross_weigth`, `sizeplusuom`, `ingredients_en`, `ingredients_fr`, `gen_description_en`, `gen_description_fr`, `kosher_list`, `image_name`, `category_slug`, `subcategory_slug`, `product_slug`, `creation_date`, `modification_date`, `Preparation_And_Cooking_Suggestions_EN`, `Preparation_And_Cooking_Suggestions_FR`, `Serving_Suggestions_EN`, `Serving_Suggestions_FR`, `YieldPerUnit`, `YieldPerUnitUom`,`Serving_Size`,`Serving_Size_UOM`,`NumServings`,`Volume_Case`,`Volume_CuFt`,`GlutenFree`) VALUES ('0360-20012', 'HEALTHSTYLE', 'LOW CALORIE ORANGE SPREAD', 'TARTINADE D'ORANGE HYPOCALORIQUE', '180', 'BREAKFAST - HEALTH STYLE', 'BREAKFAST - PORTIONS', 'FOOD SERVICE', '00062802036014', '006280203601', '200 CUP X 12 GR','26', 'CM', '20', 'CM', '12', 'CM', '20', '10', '6.54316', '12 GR', 'Water, orange peel, concentrated orange juice, pectin, citric acid, calcium gluconate, sucralose (4 mg/12 g), potassium sorbate, sodium benzoate, mono & diglycerides (contains soy), colour.', 'Eau, écorce d\'orange, jus orange concentré, pectine, acide citrique, gluconate de calcium, sucralose (4mg/12g), sorbate de potassium, benzoate de sodium, mono et diglycérides (continent soya), colorant.', 'This fruit spread tastes delicious yet contains less than 3 calories per portion. It's made with Sucralose and in small batches to maximize freshness and flavour.', 'Cette délicieuse tartinade de fruits édulcorée avec du sucralose ne contient que 3 calories par portion. Elle est fabriquée à petite échelle afin d’en maximiser la fraîcheur et la saveur.', 'PAREVE', '0360-20012-healthstyle-low-calorie-orange-spread.jpg', 'breakfast-portions', '', 'low-calorie-orange-spread', '2015-12-08 05:33:47', '2015-12-08 05:33:47','Ready to use.','Preparation_And_Cooking_Suggestions_FR','An ideal topping for toast and bagels, at breakfast or any time of day.','Nos confitures et gel�es sont d�licieuses sur les r�ties et bagels, que ce soit au petit d�jeuner ou � toute heure du jour.','2.4','KG','12','GR','200','0.006','0.220363515125','Y')'ä','ü','ö','ß'),array('ae','ue','oe','ss'),$subcategory_slug);
//                        $subcategory_slug =preg_replace('~[^\\pL\d.]+~u', '-', $subcategory_slug);
//                        $subcategory_slug = preg_replace('#[\s]{2,}#',' ',$subcategory_slug);
//                        $subcategory_slug = str_replace(array(' '),array('-'),$subcategory_slug);
//                        $subcategory_slug = trim($subcategory_slug,'-');

                            $product_slug = trim(strtolower($product_name_en));
                            $product_slug = html_entity_decode($product_slug);
                            $product_slug = str_replace('.', '-', $product_slug);
                            $product_slug = str_replace(array('ä', 'ü', 'ö', 'ß'), array('ae', 'ue', 'oe', 'ss'), $product_slug);
                            $product_slug = preg_replace('~[^\\pL\d.]+~u', '-', $product_slug);
                            $product_slug = preg_replace('#[\s]{2,}#', ' ', $product_slug);
                            $product_slug = str_replace(array(' '), array('-'), $product_slug);
                            $product_slug = trim($product_slug, '-');
                            $date = date('Y-m-d H:i:s');

                            $count_data = $wpdb->get_var("SELECT COUNT(*) from " . $wpdb->prefix . "inventory_master where stock_code='" . $stock_code . "'");
                            //$sql_condition = mysql_query("SELECT *  from ".$wpdb->prefix."inventory_master where stock_code='".$stock_code."'");
                            //$count_data = mysql_num_rows($sql_condition);
                            //$Preparation_And_Cooking_Suggestions_FR="ffafaf";
                            if ($count_data == 0) {
                                $sql = "INSERT INTO " . $wpdb->prefix . "inventory_master (`stock_code`, `product_class_description`, `product_name_en`, `product_name_fr`,`shelflife`, `category_description`, `category_group_description`, `line_of_bussiness_description`, `scccode`, `upccode`, `packinfo2`, `length_case`, `length_uom_case`, `width_case`, `width_uom_case`, `height_case`, `height_uom_case`, `pallet_tie`, `pallet_tier`, `gross_weigth`, `sizeplusuom`, `ingredients_en`, `ingredients_fr`, `gen_description_en`, `gen_description_fr`, `kosher_list`, `image_name`, `category_slug`, `subcategory_slug`, `product_slug`, `creation_date`, `modification_date`, `Preparation_And_Cooking_Suggestions_EN`, `Preparation_And_Cooking_Suggestions_FR`, `Serving_Suggestions_EN`, `Serving_Suggestions_FR`, `YieldPerUnit`, `YieldPerUnitUom`,`Serving_Size`,`Serving_Size_UOM`,`NumServings`,`Volume_Case`,`Volume_CuFt`,`GlutenFree`,`healthy`,`For_More_Information_EN`,`For_More_Information_FR`)
                        VALUES ('$stock_code', '$product_class_description', '$product_name_en', '$product_name_fr', '$shelflife', '$category_description', '$category_group_description', '$line_of_bussiness_description', '$scccode', '$upccode', '$packinfo2','$length_case', '$length_uom_case', '$width_case', '$width_uom_case', '$height_case', '$height_uom_case', '$pallet_tie', '$pallet_tier', '$gross_weigth', '$sizeplusuom', '$ingredients_en', '$ingredients_fr', '$gen_description_en', '$gen_description_fr', '$kosher_list', '$image_name', '$category_slug', '$subcategory_slug', '$product_slug', '$date', '$date','$Preparation_And_Cooking_Suggestions_EN','" . $Preparation_And_Cooking_Suggestions_FR . "','$Serving_Suggestions_EN','" . $Serving_Suggestions_FR . "','$YieldPerUnit','$YieldPerUnitUom','$Serving_Size','$Serving_Size_UOM','$NumServings','$Volume_Case','$Volume_CuFt','$GlutenFree','$Healthy','$For_More_Information_EN','$For_More_Information_FR')";
                                //mysql_query($sql) or die(mysql_error());
//                                echo "<br>";
                                $wpdb->query($sql);
                                //exit;
                                //exit;
                            }
                        }
                    }
                }
                $success = '<p class="success">Inventory  Values Has Been Uploaded To Database</p>';
            }
        } else {
            $error = '<p>Please upload  .xls file only</p>';
        }
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="span6" id="form-login">
    <?php
    if (isset($error)) {
        echo $error;
    }
    if (isset($success)) {
        echo $success;
    }
    ?>
                <form class="form-horizontal well"  method="post" name="upload_excel" enctype="multipart/form-data"  accept-charset="utf-8">
                    <fieldset>
                        <legend>Import Inventory Master Excel file</legend>
                        <div class="control-group">
                            <div class="control-label">
                                <label>Upload Inventory Master:</label>
                            </div>
                            <div class="controls">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" id="submit" value="Import Inventory" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>      
        </div>
    </div>
    <?php
}

// for data uploading of inventory master table ends
// for data uploading of nutritional info  table start
function add_nutritional_info() {
    global $wpdb;
    $error = '';
    $success = '';
    if (isset($_POST["Import_Nut_Info"])) {
        $filename = rand(2, 1000) . '_' . $_FILES['file']['name'];
        $fileextension = explode(".", $filename);
        $fileextension = end($fileextension);
        if ($fileextension == 'xls') {
            $sql_truncate = "TRUNCATE TABLE wp_nutritional_info";
            mysql_query($sql_truncate) or die(mysql_error());
            move_uploaded_file($_FILES['file']['tmp_name'], ABSPATH . "/wp-content/plugins/product_import/excel_file/" . $filename);
            $data = new Spreadsheet_Excel_Reader(ABSPATH . "/wp-content/plugins/product_import/excel_file/" . $filename);
            if ($_FILES["file"]["size"] > 0) {
                for ($i = 0; $i < count($data->sheets); $i++) {
                    if (count($data->sheets[$i][cells]) > 0) {
                        for ($j = 2; $j <= count($data->sheets[$i][cells]); $j++) {
                            $data->sheets[$i][cells][$j][1];
                            $stock_code = trim(esc_sql($data->sheets[$i][cells][$j][1]));
                            $stock_code_description = trim(esc_sql($data->sheets[$i][cells][$j][2]));
                            $serving_size = trim(esc_sql($data->sheets[$i][cells][$j][3]));
                            $serving_size_uom = trim(esc_sql($data->sheets[$i][cells][$j][4]));
                            $prepared_serving = trim(esc_sql($data->sheets[$i][cells][$j][5]));
                            $prepared_serving_uom = trim(esc_sql($data->sheets[$i][cells][$j][6]));
                            $energy = trim(esc_sql($data->sheets[$i][cells][$j][7]));
                            $total_fat = trim(esc_sql($data->sheets[$i][cells][$j][8]));
                            $rdi_total_fat = trim(esc_sql($data->sheets[$i][cells][$j][9]));
                            $saturated_fat = trim(esc_sql($data->sheets[$i][cells][$j][10]));
                            $trans_fatty_acids = trim(esc_sql($data->sheets[$i][cells][$j][11]));
                            $rdi_saturated_trans_fatty_acids = trim(esc_sql($data->sheets[$i][cells][$j][12]));
                            $cholesterol = trim(esc_sql($data->sheets[$i][cells][$j][13]));
                            $sodium = trim(esc_sql($data->sheets[$i][cells][$j][14])); //specialty
                            $rdi_sodium = trim(esc_sql($data->sheets[$i][cells][$j][15])); // notes
                            $carbohydrate = trim(esc_sql($data->sheets[$i][cells][$j][16]));
                            $rdi_carbohydrate = trim(esc_sql($data->sheets[$i][cells][$j][17]));
                            $fibre = trim(esc_sql($data->sheets[$i][cells][$j][18]));
                            $rdi_fibre = trim(esc_sql($data->sheets[$i][cells][$j][19]));
                            $sugar = trim(esc_sql($data->sheets[$i][cells][$j][20]));
                            $protein = trim(esc_sql($data->sheets[$i][cells][$j][21]));
                            $vitamin_a = trim(esc_sql($data->sheets[$i][cells][$j][22]));
                            $vitamin_c = trim(esc_sql($data->sheets[$i][cells][$j][23]));
                            $calcium = trim(esc_sql($data->sheets[$i][cells][$j][24]));
                            $iron = trim(esc_sql($data->sheets[$i][cells][$j][25]));
                            $sucralose = trim(esc_sql($data->sheets[$i][cells][$j][26]));
                            $aspartame = trim(esc_sql($data->sheets[$i][cells][$j][27]));
                            $nutritional_information = trim(esc_sql($data->sheets[$i][cells][$j][28]));
                            $date = date('Y-m-d H:i:s');
                            $sql_condition = mysql_query("SELECT *  from " . $wpdb->prefix . "nutritional_info where stock_code='" . $stock_code . "'");
                            $count_data = mysql_num_rows($sql_condition);
                            if ($count_data == 0) {
                                $sql = "INSERT INTO " . $wpdb->prefix . "nutritional_info (`stock_code`, `stock_code_description`, `serving_size`, `serving_size_uom`, `prepared_serving`, `prepared_serving_uom`, `energy`, `total_fat`, `rdi_total_fat`, `saturated_fat`, `trans_fatty_acids`, `rdi_saturated_trans_fatty_acids`, `cholesterol`, `sodium`, `rdi_sodium`, `carbohydrate`, `rdi_carbohydrate`, `fibre`, `rdi_fibre`, `sugar`, `protein`, `vitamin_a`, `vitamin_c`, `calcium`, `iron`, `sucralose`,`aspartame`,`nutritional_information`,`creation_date`)
                                 VALUES ('$stock_code', '$stock_code_description', '$serving_size', '$serving_size_uom', '$prepared_serving', '$prepared_serving_uom', '$energy', '$total_fat', '$rdi_total_fat', '$saturated_fat', '$trans_fatty_acids', '$rdi_saturated_trans_fatty_acids', '$cholesterol', '$sodium', '$rdi_sodium', '$carbohydrate', '$rdi_carbohydrate', '$fibre', '$rdi_fibre', '$sugar', '$protein', '$vitamin_a', '$vitamin_c', '$calcium', '$iron', '$sucralose','$aspartame','$nutritional_information','$date')";
                                mysql_query($sql) or die(mysql_error());
                            }
                        }
                    }
                }
                $success = '<p class="success">Nutritional Info Values Has Been Uploaded To Database</p>';
            }
        } else {
            $error = '<p class="error">Please Upload .xls File Only</p>';
        }
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="span6" id="form-login">
    <?php
    if (isset($error)) {
        echo $error;
    }
    if (isset($success)) {
        echo $success;
    }
    ?>
                <form class="form-horizontal well"  method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Import Nutritional Info Excel file</legend>
                        <div class="control-group">
                            <div class="control-label">
                                <label>Upload Nutritional Info:</label>
                            </div>
                            <div class="controls">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" id="submit" value="Import Nutritional Info" name="Import_Nut_Info" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <?php
}

// for data uploading of nutritional info  table 
?>