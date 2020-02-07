<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;

class WebScraperController extends Controller
{
    public function index()
    {
        include("simple_html_dom.php");

        $address_temp = array();
        $address = array();
        $phone = array();
        $ar = array();
        $list_check = array();
        $company = array();
        //   $data_table = [];

        $phone = array();
        $description = array();
        $data_table2 = array();
        $location = array();


        for ($iii = 1; $iii < 210; $iii++) {
            $html = file_get_html('https://www.medpages.info/sf/index.php?page=newsearchresults&q=Allied&sp=no&lat=&long=1&pageno=' . $iii);

            //$list=$html->find('section[class="result-record"]',$x);
            $list_array = $html->find('a');

            for ($i = 0; $i < count($list_array); $i++) {
                $list_check[] = $list_array[$i]->href;
            }

            for ($com = 0; $com < 10; $com++) {
                $company[] = $html->find('h2', $com)->plaintext;
            }
            for ($loc = 1; $loc < 10; $loc++) {
                $loc_ar = $html->find('div[class="result-details"]', $loc);
                for ($ziw = 0; $ziw < 1; $ziw++) {
                    if ($loc_ar) {
                        $location[] = $loc_ar->find('h4', $ziw)->plaintext;
                    }
                }
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

                for ($e = 0; $e < 10; $e++) {
                    $link_ar = $html2->find('section[class="contact-info bottom-border"]', $e);


                    for ($sy = 0; $sy < 10; $sy++) {

                        //work on this shit tommorrow
                        if ($link_ar) {
                            $data_table = $link_ar->find('table[class="info-table"]', $sy);
                            //Stop

                            for ($zi = 0; $zi < 1; $zi++) {
                                if ($data_table) {
                                    $phone[] = $data_table->find('td[class="col-lg-10 text-left"]', $zi)->plaintext;
                                }
                            }

                            $data_table2 = $link_ar->find('table[class="info-table"]', $sy);
                            for ($fi = 1; $fi < 2; $fi++) {
                                if (!empty($data_table2)) {
                                    $address[] = $data_table2->find('td[class="col-lg-10 text-left"]', $fi)->plaintext;
                                }
                            }
                        }
                    }
                }
            }
            // for ($ui = 0; $ui < count($data_table2); $ui++) {
            //     for ($li = 0; $li < 2000; $li++) {
            //         if ($data_table2[$ui]) {

            //             $address_temp = $data_table2->find('td[class="col-lg-10 text-left"]', $li);
            //         }
            //     }
            //     $address[] = $address_temp->plaintext;
            // }





            for ($kkk = 0; $kkk < count($address); $kkk++) {
                $data_ar = "";
                if (strlen($address[$kkk]) > 15) {
                    $data_ar = $address[$kkk];
                } else {
                    $data_ar = "NULL";
                }

                $address_temp[] =  $data_ar;
            }

            // for ($zz = 0; $zz < count($address_temp); $zz++) {
            //     echo $address_temp[$zz];
            // }

            for ($ui = 0; $ui < count($location); $ui++) {
                echo  $location[$ui];
            }

            return "stop";


            for ($zi = 0; $zi < 1; $zi++) {
                if ($data_table) {
                    $phone[] = $data_table->find('td[class="col-lg-10 text-left"]', $zi);
                }
            }
            // $description[] = $zink_descr[$zi]->find('td[class="col-lg-10 text-left"]', $gi)->plaintext;



            // for ($fi = 0; $fi < 10; $fi++) {
            //     $data1 = $data_table[$zi]->find('td[class="col-lg-10 text-left"]', $fi);
            //     if (strlen($data1) > 15) {
            //         $address[] = $data1;
            //     }
            // }




            for ($ui = 0; $ui < count($location); $ui++) {
                echo  $location[$ui];
            }
        }


        return "stop";
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