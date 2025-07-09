<?php include('Views/_partials/header.php'); ?>
     <div class="w-full h-full col-span-7">
 <div class="w-full h-dvw flex flex-col  w-full h-dvh overflow-y-auto p-4  bg-white dark:bg-gray-900">
      <div class="w-full h-dvw h-full flex flex-col bg-white dark:bg-gray-900">
        <div class="w-full flex items-center justify-between">
          <header class="py-4 flex items-start  flex-col">
            <div class="flex items-start gap-2">
              <div>
                <h1 class="text-xl font-bold">Products</h1>
                <h5 class="text-sm text-gray-600"></h5>
              </div>
            </div>
          </header>
          <div class="max-w-sm w-full flex items-center justify-center py-2 gap-2 z-50">
            <div class="w-full flex relative flex-col gap-1">
              <label class="font-semibold text-xs text-gray-400 "></label><input type="text" class="border rounded-lg px-3 py-2 mb-0 text-sm w-full outline-none focus:border-primary-500" placeholder="Buscar proyecto por título o ID" required="" value="">
            </div>
            <div>
              <div
                class="bg-primary-600 hover:bg-primary-800 text-white flex justify-start items-center gap-1 py-2 px-3  focus:ring-offset-blue-200 w-full transition ease-in duration-200 text-center text-base  shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg outline-none cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M5 12h7m7 0h-7m0 0V5m0 7v7"></path>
                </svg>Crear</div>
            </div>
          </div>
        </div>
        <div class="flex flex-col overflow-y-auto h-full">
          <table class="min-w-full bg-white border undefined">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 h-6 sticky top-0 z-10 transition-all ease-in-out ">
              <tr>
                <th class="px-2 2xl:px-6 py-3 bg-gray-200 w-8"></th>
                <th class="px-2 2xl:px-6 py-3 bg-gray-200">Product Name</th>
                <th class="px-2 2xl:px-6 py-3 bg-gray-200">Create At</th>
                <th class="px-2 2xl:px-6 py-3 bg-gray-200">State</th>
                <th class="px-2 2xl:px-6 py-3 bg-gray-200 w-6"></th>
              </tr>
            </thead>
            <tbody class="undefined select-none">
              <tr class="border-b">
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center"><input type="checkbox" class="w-4 h-4">
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm">
                  <div class="flex items-center gap-2"><img src="https://firebasestorage.googleapis.com/v0/b/amethgalarcio.appspot.com/o/images%2FCaptura%20de%20pantalla%202024-11-08%20151438.png?alt=media&amp;token=60ba8e16-f724-49d2-9e34-8c812ccd212b" alt="image" class="aspect-square rounded-lg object-cover h-16">
                    <p class="font-bold">SendBot </p>
                  </div>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">mar, 5 nov de 2024</td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">
                  <span class="text-xs font-bold me-2 px-2.5 shadow py-2  bg-green-200 text-green-600 font-semibold rounded-lg shadow">stocked</span>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm   flex justify-center items-center h-full gap-2">
                  <div class="relative inline-block text-left select-none ">
                    <div class="rounded-full py-4 hover:bg-gray-100 focus:outline- cursor-pointer "><svg
                        xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                        <path fill="currentColor"
                          d="M12 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2">
                        </path>
                      </svg></div>
                  </div>
                </td>
              </tr>
              <tr class="border-b">
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center"><input type="checkbox" class="w-4 h-4">
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm">
                  <div class="flex items-center gap-2"><img src="https://firebasestorage.googleapis.com/v0/b/amethgalarcio.appspot.com/o/images%2Foriginal-ef2cfaa92caa023ef8e6f3c14b2a79c7.png?alt=media&amp;token=a83d97a2-611f-41d6-ad85-7ea8d5c6c2c2" alt="image" class="aspect-square rounded-lg object-cover h-16">
                    <p class="font-bold">Whatsapp Bot </p>
                  </div>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">vie, 25 oct de 2024</td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">
                  <span class="text-xs font-bold me-2 px-2.5 shadow py-2  bg-green-200 text-green-600 font-semibold rounded-lg shadow">stocked</span>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm   flex justify-center items-center h-full gap-2">
                  <div class="relative inline-block text-left select-none ">
                    <div class="rounded-full py-4 hover:bg-gray-100 focus:outline- cursor-pointer "><svg
                        xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                        <path fill="currentColor"
                          d="M12 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2">
                        </path>
                      </svg></div>
                  </div>
                </td>
              </tr>
              <tr class="border-b">
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center"><input type="checkbox" class="w-4 h-4">
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm">
                  <div class="flex items-center gap-2"><img src="https://firebasestorage.googleapis.com/v0/b/amethgalarcio.appspot.com/o/images%2Frapidrive-1.png?alt=media&amp;token=9a8df828-8f60-48d5-a5ec-08cc99776782" alt="image" class="aspect-square rounded-lg object-cover h-16">
                    <p class="font-bold"> RapiDrive: Explore Your Ride Options</p>
                  </div>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">mié, 6 nov de 2024</td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">
                  <span class="text-xs font-bold me-2 px-2.5 shadow py-2  bg-green-200 text-green-600 font-semibold rounded-lg shadow">stocked</span>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm   flex justify-center items-center h-full gap-2">
                  <div class="relative inline-block text-left select-none ">
                    <div class="rounded-full py-4 hover:bg-gray-100 focus:outline- cursor-pointer "><svg
                        xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                        <path fill="currentColor"
                          d="M12 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2">
                        </path>
                      </svg></div>
                  </div>
                </td>
              </tr>
              <tr class="border-b">
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center"><input type="checkbox" class="w-4 h-4">
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm">
                  <div class="flex items-center gap-2"><img src="https://firebasestorage.googleapis.com/v0/b/amethgalarcio.appspot.com/o/images%2Fqr-screen.png?alt=media&amp;token=b1a07d72-598d-4c70-95a7-75ba3dfdf20d" alt="image" class="aspect-square rounded-lg object-cover h-16">
                    <p class="font-bold"> QR-Create</p>
                  </div>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">mar, 5 nov de 2024</td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">
                  <span class="text-xs font-bold me-2 px-2.5 shadow py-2  bg-green-200 text-green-600 font-semibold rounded-lg shadow">stocked</span>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm   flex justify-center items-center h-full gap-2">
                  <div class="relative inline-block text-left select-none ">
                    <div class="rounded-full py-4 hover:bg-gray-100 focus:outline- cursor-pointer "><svg
                        xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                        <path fill="currentColor"
                          d="M12 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2">
                        </path>
                      </svg></div>
                  </div>
                </td>
              </tr>
              <tr class="border-b">
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center"><input type="checkbox" class="w-4 h-4">
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm">
                  <div class="flex items-center gap-2"><img src="https://firebasestorage.googleapis.com/v0/b/amethgalarcio.appspot.com/o/images%2FCaptura%20de%20pantalla%202025-01-23%20175240.png?alt=media&amp;token=ac37cdb8-5ab8-4e61-a7e4-a78df396a483" alt="image" class="aspect-square rounded-lg object-cover h-16">
                    <p class="font-bold">Sing Song </p>
                  </div>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">jue, 23 ene de 2025</td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">
                  <span class="text-xs font-bold me-2 px-2.5 shadow py-2  bg-green-200 text-green-600 font-semibold rounded-lg shadow">stocked</span>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm   flex justify-center items-center h-full gap-2">
                  <div class="relative inline-block text-left select-none ">
                    <div class="rounded-full py-4 hover:bg-gray-100 focus:outline- cursor-pointer "><svg
                        xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                        <path fill="currentColor"
                          d="M12 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2">
                        </path>
                      </svg></div>
                  </div>
                </td>
              </tr>
              <tr class="border-b">
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center"><input type="checkbox" class="w-4 h-4">
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm">
                  <div class="flex items-center gap-2"><img src="https://firebasestorage.googleapis.com/v0/b/amethgalarcio.appspot.com/o/images%2Fmockup%20product-Lprx8PWW.jpg?alt=media&amp;token=580fe6a9-b35f-497b-9c79-0f845e010855" alt="image" class="aspect-square rounded-lg object-cover h-16">
                    <p class="font-bold">SendWave </p>
                  </div>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">vie, 25 oct de 2024</td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">
                  <span class="text-xs font-bold me-2 px-2.5 shadow py-2  bg-green-200 text-green-600 font-semibold rounded-lg shadow">stocked</span>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm   flex justify-center items-center h-full gap-2">
                  <div class="relative inline-block text-left select-none ">
                    <div class="rounded-full py-4 hover:bg-gray-100 focus:outline- cursor-pointer "><svg
                        xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                        <path fill="currentColor"
                          d="M12 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2">
                        </path>
                      </svg></div>
                  </div>
                </td>
              </tr>
              <tr class="border-b">
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center"><input type="checkbox" class="w-4 h-4">
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm">
                  <div class="flex items-center gap-2"><img src="https://firebasestorage.googleapis.com/v0/b/amethgalarcio.appspot.com/o/images%2FApp.png?alt=media&amp;token=47ba7929-0cd1-4ed2-8b0a-11aaebf2c6ac" alt="image" class="aspect-square rounded-lg object-cover h-16">
                    <p class="font-bold">Pidelo!</p>
                  </div>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">vie, 25 oct de 2024</td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm  text-center">
                  <span class="text-xs font-bold me-2 px-2.5 shadow py-2  bg-green-200 text-green-600 font-semibold rounded-lg shadow">stocked</span>
                </td>
                <td class="px-6 py-1.5 whitespace-nowrap text-sm   flex justify-center items-center h-full gap-2">
                  <div class="relative inline-block text-left select-none ">
                    <div class="rounded-full py-4 hover:bg-gray-100 focus:outline- cursor-pointer "><svg
                        xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                        <path fill="currentColor"
                          d="M12 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2">
                        </path>
                      </svg></div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>
</div>
<?php include('Views/_partials/footer.php'); ?>
