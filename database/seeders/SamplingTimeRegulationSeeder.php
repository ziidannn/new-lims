<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SamplingTimeRegulation;

class SamplingTimeRegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
// parameter 1-9 regulation code 011
            [ // 1
                "id" => "1",
                "parameter_id" => "1",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [
                "id" => "2",
                "parameter_id" => "1",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [
                "id" => "3",
                "parameter_id" => "1",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "5",
            ],
            [ // 2
                "id" => "4",
                "parameter_id" => "2",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "16",
            ],
            [
                "id" => "5",
                "parameter_id" => "2",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "15",
            ],
            [ // 3
                "id" => "6",
                "parameter_id" => "3",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "7",
                "parameter_id" => "3",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "8",
            ],
            [ 
                "id" => "8",
                "parameter_id" => "3",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "6",
            ],
            [ // 4
                "id" => "9",
                "parameter_id" => "4",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "10",
                "parameter_id" => "4",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "10",
            ],
            [ 
                "id" => "11",
                "parameter_id" => "4",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "3",
            ],
            [ // 5
                "id" => "12",
                "parameter_id" => "5",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "13",
                "parameter_id" => "6",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "17",
            ],
            [ 
                "id" => "14",
                "parameter_id" => "6",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            [ // 7
                "id" => "15",
                "parameter_id" => "7",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [ 
                "id" => "16",
                "parameter_id" => "7",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "4",
            ],
            [ // 8
                "id" => "17",
                "parameter_id" => "8",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "7",
            ],
            [ 
                "id" => "18",
                "parameter_id" => "8",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "2",
            ],
            [ // 9
                "id" => "19",
                "parameter_id" => "9",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
// parameter 1-9 regulation code 012
            [ // 1
                "id" => "20",
                "parameter_id" => "10",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [
                "id" => "21",
                "parameter_id" => "10",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [
                "id" => "22",
                "parameter_id" => "10",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "5",
            ],
            [ // 2
                "id" => "23",
                "parameter_id" => "11",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "16",
            ],
            [
                "id" => "24",
                "parameter_id" => "11",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "15",
            ],
            [ // 3
                "id" => "25",
                "parameter_id" => "12",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "26",
                "parameter_id" => "12",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "8",
            ],
            [ 
                "id" => "27",
                "parameter_id" => "12",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "6",
            ],
            [ // 4
                "id" => "28",
                "parameter_id" => "13",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "29",
                "parameter_id" => "13",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "10",
            ],
            [ 
                "id" => "30",
                "parameter_id" => "13",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "3",
            ],
            [ // 5
                "id" => "31",
                "parameter_id" => "14",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "32",
                "parameter_id" => "15",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            [ // 7
                "id" => "33",
                "parameter_id" => "16",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [ 
                "id" => "34",
                "parameter_id" => "16",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "4",
            ],
            [ // 8
                "id" => "35",
                "parameter_id" => "17",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "7",
            ],
            [ 
                "id" => "36",
                "parameter_id" => "17",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "2",
            ],
            [ // 9
                "id" => "37",
                "parameter_id" => "18",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
// parameter 1-9 regulation code 013
            [ // 1
                "id" => "38",
                "parameter_id" => "19",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "39",
                "parameter_id" => "19",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [ 
                "id" => "40",
                "parameter_id" => "19",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "5",
            ],
            [ // 2
                "id" => "41",
                "parameter_id" => "20",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "16",
            ],
            [ 
                "id" => "42",
                "parameter_id" => "20",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "15",
            ],
            [ // 3
                "id" => "43",
                "parameter_id" => "21",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "44",
                "parameter_id" => "21",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "8",
            ],
            [ 
                "id" => "45",
                "parameter_id" => "21",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "6",
            ],
            [ // 4
                "id" => "46",
                "parameter_id" => "22",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "47",
                "parameter_id" => "22",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "48",
                "parameter_id" => "22",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "3",
            ],
            [ // 5
                "id" => "49",
                "parameter_id" => "23",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "50",
                "parameter_id" => "24",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "17",
            ],
            [
                "id" => "51",
                "parameter_id" => "24",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            [ // 7
                "id" => "52",
                "parameter_id" => "25",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [
                "id" => "53",
                "parameter_id" => "25",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "4",
            ],
            [ // 8
                "id" => "54",
                "parameter_id" => "26",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "7",
            ],
            [
                "id" => "55",
                "parameter_id" => "26",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "2",
            ],
            [ // 9
                "id" => "56",
                "parameter_id" => "27",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
            [ // 10
                "id" => "57",
                "parameter_id" => "28",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "18",
            ],
            [ // 11
                "id" => "58",
                "parameter_id" => "29",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "19",
            ],
// parameter 1-9 regulation code 014
            [ // 1
                "id" => "60",
                "parameter_id" => "30",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "61",
                "parameter_id" => "30",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [ 
                "id" => "62",
                "parameter_id" => "30",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "5",
            ],
            [ // 2
                "id" => "63",
                "parameter_id" => "31",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "16",
            ],
            [ 
                "id" => "64",
                "parameter_id" => "31",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "15",
            ],
            [ // 3
                "id" => "65",
                "parameter_id" => "32",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "66",
                "parameter_id" => "32",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "8",
            ],
            [ 
                "id" => "67",
                "parameter_id" => "32",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "6",
            ],
            [ // 4
                "id" => "68",
                "parameter_id" => "33",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "11",
            ],
            [ 
                "id" => "69",
                "parameter_id" => "33",
                "sampling_time_id" => "3",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "70",
                "parameter_id" => "33",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "3",
            ],
            [ // 5
                "id" => "71",
                "parameter_id" => "34",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "72",
                "parameter_id" => "35",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            [ // 7
                "id" => "73",
                "parameter_id" => "36",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "9",
            ],
            [
                "id" => "74",
                "parameter_id" => "36",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "4",
            ],
            [ // 8
                "id" => "75",
                "parameter_id" => "37",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "7",
            ],
            [
                "id" => "76",
                "parameter_id" => "37",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "2",
            ],
            [ // 9
                "id" => "77",
                "parameter_id" => "38",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
            [ // 10
                "id" => "78",
                "parameter_id" => "39",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "18",
            ],
            [ // 11
                "id" => "79",
                "parameter_id" => "40",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "19",
            ],
// parameter 1-9 regulation code 015
            [ // 1
                "id" => "80",
                "parameter_id" => "41",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "17",
            ],
            [
                "id" => "81",
                "parameter_id" => "41",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "20",
            ],
            [// 2
                "id" => "82",
                "parameter_id" => "42",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "17",
            ],
            [
                "id" => "83",
                "parameter_id" => "42",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "10",
            ],
            [ // 3
                "id" => "84",
                "parameter_id" => "43",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "17",
            ],
            [
                "id" => "85",
                "parameter_id" => "43",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "22",
            ],
            [
                "id" => "86",
                "parameter_id" => "43",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "21",
            ],
            [ // 4
                "id" => "87",
                "parameter_id" => "44",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "23",
            ],
            [ // 5
                "id" => "88",
                "parameter_id" => "45",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "89",
                "parameter_id" => "46",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "17",
            ],
            [
                "id" => "90",
                "parameter_id" => "46",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "24",
            ],
            [
                "id" => "91",
                "parameter_id" => "46",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "9",
            ],
            [ // 7
                "id" => "92",
                "parameter_id" => "47",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "17",
            ],
            [
                "id" => "93",
                "parameter_id" => "47",
                "sampling_time_id" => "6",
                "regulation_standard_id" => "25",
            ],
            [ // 8
                "id" => "94",
                "parameter_id" => "48",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "17",
            ],
            [
                "id" => "95",
                "parameter_id" => "48",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
            [ // 9
                "id" => "96",
                "parameter_id" => "49",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "12",
            ],
// parameter 1-9 regulation code 016
            [ // 1
                "id" => "97",
                "parameter_id" => "50",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "26",
            ],
            [ 
                "id" => "98",
                "parameter_id" => "50",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "27",
            ],
            [ 
                "id" => "99",
                "parameter_id" => "50",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "28",
            ],
            [ // 2
                "id" => "100",
                "parameter_id" => "51",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "29",
            ],
            [ 
                "id" => "101",
                "parameter_id" => "51",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "16",
            ],
            [ // 3
                "id" => "102",
                "parameter_id" => "52",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "30",
            ],
            [ 
                "id" => "103",
                "parameter_id" => "52",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "10",
            ],
            [ 
                "id" => "104",
                "parameter_id" => "52",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "11",
            ],
            [ // 4
                "id" => "105",
                "parameter_id" => "53",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "31",
            ],
            [ 
                "id" => "106",
                "parameter_id" => "53",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "6",
            ],
            [ // 5
                "id" => "107",
                "parameter_id" => "54",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "108",
                "parameter_id" => "55",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "11",
            ],
            [ // 7
                "id" => "109",
                "parameter_id" => "56",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "8",
            ],
            [ 
                "id" => "110",
                "parameter_id" => "56",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "2",
            ],
            [ // 8
                "id" => "111",
                "parameter_id" => "57",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            [ 
                "id" => "112",
                "parameter_id" => "57",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "32",
            ],
            [ // 9
                "id" => "113",
                "parameter_id" => "58",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
            [ 
                "id" => "114",
                "parameter_id" => "58",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "33",
            ],
// parameter 1-9 regulation code 017
            [ // 1
                "id" => "115",
                "parameter_id" => "59",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "26",
            ],
            [ 
                "id" => "116",
                "parameter_id" => "59",
                "sampling_time_id" => " 4",
                "regulation_standard_id" => "24",
            ],
            [ 
                "id" => "117",
                "parameter_id" => "59",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "28",
            ],
            [ // 2
                "id" => "118",
                "parameter_id" => "60",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "34",
            ],
            [ 
                "id" => "119",
                "parameter_id" => "60",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "35",
            ],
            [ // 3
                "id" => "120",
                "parameter_id" => "61",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "30",
            ],
            [ 
                "id" => "121",
                "parameter_id" => "61",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "36",
            ],
            [ 
                "id" => "122",
                "parameter_id" => "61",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "28",
            ],
            [ // 4
                "id" => "123",
                "parameter_id" => "62",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "124",
                "parameter_id" => "62",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "37",
            ],
            [ // 5
                "id" => "125",
                "parameter_id" => "63",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "126",
                "parameter_id" => "64",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "12",
            ],
            [ // 7
                "id" => "127",
                "parameter_id" => "65",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "8",
            ],
            [ 
                "id" => "128",
                "parameter_id" => "65",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "2",
            ],
            [ // 8
                "id" => "129",
                "parameter_id" => "66",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            [ 
                "id" => "130",
                "parameter_id" => "66",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "32",
            ],
            [ // 9
                "id" => "131",
                "parameter_id" => "67",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
            [ 
                "id" => "132",
                "parameter_id" => "67",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "33",
            ],
// parameter 1-9 regulation code 018
            [ // 1
                "id" => "133",
                "parameter_id" => "68",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "26",
            ],
            [ 
                "id" => "134",
                "parameter_id" => "68",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "24",
            ],
            [ 
                "id" => "135",
                "parameter_id" => "68",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "28",
            ],
            [ // 2
                "id" => "136",
                "parameter_id" => "69",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "34",
            ],
            [ 
                "id" => "137",
                "parameter_id" => "69",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "35",
            ],
            [ // 3
                "id" => "138",
                "parameter_id" => "70",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "30",
            ],
            [ 
                "id" => "139",
                "parameter_id" => "70",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "36",
            ],
            [ 
                "id" => "140",
                "parameter_id" => "70",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "28",
            ],
            [ // 4
                "id" => "141",
                "parameter_id" => "71",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "13",
            ],
            [ 
                "id" => "142",
                "parameter_id" => "71",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "37",
            ],
            [ // 5
                "id" => "143",
                "parameter_id" => "72",
                "sampling_time_id" => "2",
                "regulation_standard_id" => "12",
            ],
            [ // 6
                "id" => "144",
                "parameter_id" => "73",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "12",
            ],
            [ // 7
                "id" => "145",
                "parameter_id" => "74",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "8",
            ],
            [ 
                "id" => "146",
                "parameter_id" => "74",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "2",
            ],
            [ // 8
                "id" => "147",
                "parameter_id" => "75",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "14",
            ],
            [ 
                "id" => "148",
                "parameter_id" => "75",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "32",
            ],
            [ // 9
                "id" => "149",
                "parameter_id" => "76",
                "sampling_time_id" => "4",
                "regulation_standard_id" => "1",
            ],
            [ 
                "id" => "150",
                "parameter_id" => "76",
                "sampling_time_id" => "5",
                "regulation_standard_id" => "33",
            ],
            [ // 10
                "id" => "151",
                "parameter_id" => "77",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "18",
            ],
            [ // 11
                "id" => "152",
                "parameter_id" => "78",
                "sampling_time_id" => "1",
                "regulation_standard_id" => "19",
            ],
// parameter 1-9 regulation code 021
            [ // 1
                "id" => "153",
                "parameter_id" => "79",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "38",
            ],
            [ // 2
                "id" => "154",
                "parameter_id" => "80",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "39",
            ],
            [ // 3
                "id" => "155",
                "parameter_id" => "81",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "41",
            ],
            [ // 4
                "id" => "156",
                "parameter_id" => "82",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "42",
            ],
            [ // 5
                "id" => "157",
                "parameter_id" => "83",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "43",
            ],
            [ // 6
                "id" => "158",
                "parameter_id" => "84",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "33",
            ],
            [ // 7
                "id" => "159",
                "parameter_id" => "85",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "40",
            ],
            [ // 8
                "id" => "160",
                "parameter_id" => "86",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "44",
            ],
            [ // 9
                "id" => "161",
                "parameter_id" => "87",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "45",
            ],
// parameter 1-9 regulation code 022
            [ // 1
                "id" => "162",
                "parameter_id" => "88",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "46",
            ],
            [ // 2
                "id" => "163",
                "parameter_id" => "89",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "47",
            ],
            [ // 3
                "id" => "164",
                "parameter_id" => "90",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "38",
            ],
            [ // 4
                "id" => "165",
                "parameter_id" => "91",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "39",
            ],
            [ // 5
                "id" => "166",
                "parameter_id" => "92",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "41",
            ],
            [ // 6
                "id" => "167",
                "parameter_id" => "93",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "42",
            ],
            [ // 7
                "id" => "168",
                "parameter_id" => "94",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "43",
            ],
            [ // 8
                "id" => "169",
                "parameter_id" => "95",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "33",
            ],
            [ // 9
                "id" => "170",
                "parameter_id" => "96",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "40",
            ],
            [ // 10
                "id" => "171",
                "parameter_id" => "97",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "44",
            ],
            [ // 11
                "id" => "172",
                "parameter_id" => "98",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "45",
            ],
// parameter 1-9 regulation code 023
            [ // 1
                "id" => "173",
                "parameter_id" => "99",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "48",
            ],
            [ // 2
                "id" => "174",
                "parameter_id" => "100",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "47",
            ],
            [ // 3
                "id" => "175",
                "parameter_id" => "101",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "49",
            ],
            [ // 4
                "id" => "176",
                "parameter_id" => "102",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "17",
            ],
            [ // 5
                "id" => "177",
                "parameter_id" => "103",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "42",
            ],
            [ // 6
                "id" => "178",
                "parameter_id" => "104",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "41",
            ],
            [ // 7
                "id" => "179",
                "parameter_id" => "105",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "50",
            ],
            [ // 8
                "id" => "180",
                "parameter_id" => "106",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "51",
            ],
// parameter 1-9 regulation code 031
            [ // 1
                "id" => "181",
                "parameter_id" => "107",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "52",
            ],
// parameter 1-9 regulation code 032
            [ // 1
                "id" => "182",
                "parameter_id" => "109",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "52",
            ],
// parameter 1-9 regulation code 033
            [ // 1
                "id" => "183",
                "parameter_id" => "110",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "52",
            ],
// parameter 1-9 regulation code 034
            [ // 1
                "id" => "184",
                "parameter_id" => "112",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "53",
            ],
// parameter 1-9 regulation code 041
            [ // 1
                "id" => "185",
                "parameter_id" => "113",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "30",
            ],
            [ // 2
                "id" => "186",
                "parameter_id" => "114",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "54",
            ],
            [ // 3
                "id" => "187",
                "parameter_id" => "115",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "55",
            ],
            [ // 4
                "id" => "188",
                "parameter_id" => "116",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "10",
            ],
// parameter 1-9 regulation code 042
            [ // 1
                "id" => "189",
                "parameter_id" => "117",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "13",
            ],
            [ // 2
                "id" => "190",
                "parameter_id" => "118",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "56",
            ],
            [ // 3
                "id" => "191",
                "parameter_id" => "119",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "55",
            ],
// parameter 1-9 regulation code 042
            [ // 1
                "id" => "192",
                "parameter_id" => "120",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "39",
            ],
            [ // 2
                "id" => "193",
                "parameter_id" => "121",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "57",
            ],
            [ // 3
                "id" => "194",
                "parameter_id" => "122",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "58",
            ],
            [ // 4
                "id" => "195",
                "parameter_id" => "123",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "59",
            ],
            [ // 5
                "id" => "196",
                "parameter_id" => "124",
                "sampling_time_id" => "7",
                "regulation_standard_id" => "60",
            ],
        ];

        foreach ($data as $x) {
            if(!SamplingTimeRegulation::where('id', $x['id'])->first()){
                $m = new SamplingTimeRegulation();
                $m->id = $x['id'];
                $m->parameter_id = $x['parameter_id'];
                $m->sampling_time_id = $x['sampling_time_id'];
                $m->regulation_standard_id = $x['regulation_standard_id'];
                $m->save();
            }
        }
    }
}
