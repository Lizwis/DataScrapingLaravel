<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Eddieace\PhpSimple\HtmlDomParser;

class WebScraperController extends Controller
{
    public function index()
    {

        for ($iii = 1; $iii < 29; $iii++) {
            $html = HtmlDomParser::file_get_html('https://www.medpages.info/sf/index.php?page=newsearchresults&q=Allied&sp=no&lat=&long=1&pageno=' . $iii);

            $ar = array();
            $list_check = array();
            $company = array();

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
            $link_descr = array();
            for ($s = 0; $s < count($ar); $s++) {
                $html2 = HtmlDomParser::file_get_html('https://www.medpages.info/sf/' . $ar[$s]);

                for ($e = 0; $e < 10; $e++) {
                    $list_div_ds = $html2->find('section[class="main-record-info"]', $e);

                    $list_div = $html2->find('section[class="contact-info bottom-border"]', $e);

                    for ($b = 0; $b < count($list_div); $b++) {
                        $link_ar[] = $list_div->find('table[class="info-table"]', $b);
                        $link_descr[] = $list_div_ds->find('table[class="info-table"]', $b);
                    }
                }
            }

            $telephone = array();
            $address = array();
            $phone = array();
            $dd = array();
            //
            $zz = 0;
            $data2 = array();
            $address = array();

            $description = array();
            //print_r($link_ar);
            for ($li = 0; $li < count($link_ar); $li++) {

                for ($gi = 0; $gi < 1; $gi++) {
                    $phone[] = $link_ar[$li]->find('td[class="col-lg-10 text-left"]', $gi)->plaintext;

                    $description[] = $link_descr[$li]->find('td[class="col-lg-10 text-left"]', $gi)->plaintext;
                }
                for ($fi = 0; $fi < 10; $fi++) {

                    $data1 = $link_ar[$li]->find('td[class="col-lg-10 text-left"]', $fi)->plaintext;
                    $num = substr($data1, -1);
                    if (strlen($data1) > 15) {
                        $address[] = $data1;
                    }
                }
            }

            for ($i = 0; $i < count($company); $i++) {

                $catergory = "Allied professionals (Physio's; Chiro's; etc.)";
                $data = array(
                    'companyname' => $company[$i],
                    'telephone' => $phone[$i],
                    'address' => $address[$i],
                    'catergory' => $catergory,
                );
                $this->db->insert('medical_directory_catergories2', $data);
            }
        }
    }
}