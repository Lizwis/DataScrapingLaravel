<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;

class WebScraperController extends Controller
{
    public function index()
    {
        include("simple_html_dom.php");


        $address = "";
        $phone = 0;

        //
        $zz = 0;
        $data19 = array();

        $ar = array();
        $list_check = array();
        $company = array();



        for ($iii = 1; $iii < 29; $iii++) {
            $html = file_get_html('https://www.medpages.info/sf/index.php?page=newsearchresults&q=Allied&sp=no&lat=&long=1&pageno=' . $iii);

            //$list=$html->find('section[class="result-record"]',$x);
            $list_array = $html->find('a');

            for ($i = 0; $i < count($list_array); $i++) {
                $list_check[] = $list_array[$i]->href;
            }

            for ($com = 0; $com < 10; $com++) {
                $company[] = $html->find('h2', $com)->plaintext;
            }

            //$num=substr($data1, -1)
            for ($i = 0; $i < count($list_check); $i++) {

                $check = substr($list_check[$i], -3);


                if (is_numeric($check)) {
                    if (strlen($list_check[$i]) > 18) {
                        $ar[] = $list_check[$i];
                    }
                }
            }

            //getting all contacts in the table as html, assign html table to a value
            $link_ar = array();

            for ($s = 0; $s < count($ar); $s++) {
                $html2 = file_get_html('https://www.medpages.info/sf/' . $ar[$s]);

                for ($e = 0; $e < 10; $e++) {
                    //  $list_div_ds[] = $html2->find('section[class="main-record-info"]', $e);

                    $link_ar[] = $html2->find('section[class="contact-info bottom-border"]', $e);


                    //
                }
            }


            // for ($vv = 0; $vv < count($list_div); $vv++) {
            //     return  $link_ar[] = $list_div->find('td', $vv);
            // }


            //print_r($link_ar);
            for ($li = 0; $li < count($link_ar); $li++) {

                // for ($gi = 0; $gi < 1; $gi++) {
                //     $phone = $link_ar[$gi]->find('td[class="col-lg-10 text-left"]');

                //     // $description[] = $link_ar[$li]->find('td[class="col-lg-10 text-left"]', $gi)->plaintext;
                // }

                $index = 2;
                $start = 0;
                for ($fi =  $start; $fi < $index; $fi++) {
                    $data1 = "";

                    $data1 = $link_ar[$li]->find('td[class="col-lg-10 text-left"]', $fi)->plaintext;

                    $num = substr($data1, 8, 2);
                    if (is_numeric($num)) {
                        $index = $index + 1;
                        $start = $start + 1;
                    } else {
                        $address = $data1;
                    }
                }
            }
        }



        for ($i = 0; $i < count($company); $i++) {
            if (!empty($company[$i]) && !empty($address[$i]) && !empty($phone[$i])) {
                $data = new Company;
                $data->catergory_id = 1;
                $data->name = $company[$i];
                $data->address = $address[$i];
                $data->telephone = $phone[$i];
                //  $data->description = $description[$i];
                $data->save();
            }
        }
    }
}