<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;

class WebScraperController extends Controller
{
    public function index()
    {
        include("simple_html_dom.php");


        $address = array();
        $phone = array();
        $ar = array();
        $list_check = array();
        $company = array();
        $link_ar = array();





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
            $df = array();
            for ($s = 0; $s < count($ar); $s++) {
                $html2 = file_get_html('https://www.medpages.info/sf/' . $ar[$s]);

                $link_ar = $html2->find('section[class="contact-info bottom-border"]', $s);



                // return "Stop";



                for ($sy = 0; $sy < 10; $sy++) {
                    //work on this shit tommorrow
                    $data[] = $link_ar->find('td[class="col-lg-10 text-left"]', $sy);
                    //Stop

                }
            }




            for ($kkk = 0; $kkk < count($data); $kkk++) {
                echo  $data[$kkk];
            }



            return 1;









            // for ($vv = 0; $vv < count($list_div); $vv++) {
            //     return  $link_ar[] = $list_div->find('td', $vv);
            // }


            //print_r($link_ar);
            for ($li = 0; $li < 10; $li++) {


                echo $link_ar[$li];
                echo "<br/>";




                // $description[] = $link_ar[$li]->find('td[class="col-lg-10 text-left"]', $gi)->plaintext;

                //return $address = $link_ar[1]->find('td[class="col-lg-10 text-left"]');

                // $num = substr($data1, 8, 2);
                // if (is_numeric($num)) {
                //     $index = $index + 1;
                //     $start = $start + 1;
                // } else {
                //     return $address = $data1;
                // }
            }
            return "stop";
        }

        //  return $phone;

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