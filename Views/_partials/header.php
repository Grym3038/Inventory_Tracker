<?php
/**
 * Title: Header Partial
 * Purpose: To provide a header for all pages of the application and include
 *          navigation links
 */
?>
<!DOCTYPE html>
<html lang="en-us" class=" ">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mike's Mowing</title>

        <link rel="stylesheet" href="src\output.css" />

    <link rel="stylesheet" href="Lib\CSS\styles.css?v=2">
    <link href="Lib\Images\Logo_Mower_Black.svg" rel="icon" media="(prefers-color-scheme: light)">
    <link href="Lib\Images\Logo_Mower_White.svg" rel="icon" media="(prefers-color-scheme: dark)">


</head>
<body class="bg-[#f4efd8] text-black">
<div class="relative min-h-screen">


<header>
    <nav class=" border-gray-200 px-0 lg:px-0 py-2.5 " >
        <div class="bg-[#28523330] w-screen px-4 lg:px-6 py-2 mt-6 flex flex-wrap justify-between items-center " style="  backdrop-filter: blur(3px);">
            <a href="?action=home" class="flex items-center w-1/3 ">
                
                <!-- <img src="Lib\Images\Logo_Mower_black.svg" class="mr-3 mb-4 h-6 p-0 sm:h-9" alt="mikes mowing logo" /> -->
                <img src="Lib\Images\Logo_Words_White.svg" class=" lg:md:mr-3 mt-0 lg:md:p-1 h-3 sm:h-9 h-full" alt="mikes mowing logo woreds" />
            </a>
            <div class="flex items-center lg:order-2">
                <a href="#" class="text-white bg-[#00631a] hover:bg-[#00631a80] focus:ring-4 focus:ring-green-800 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 focus:outline-none">Get Estimate</a>
                <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-800" aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    <svg class="hidden w-6 h-6" fill="white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-white rounded hover:text-gray-200 lg:p-0 " aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:text-gray-200  lg:border-0  lg:p-0">About</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:text-gray-200  lg:border-0 lg:p-0">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
        
    </nav>
</header>
