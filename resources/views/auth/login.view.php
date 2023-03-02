<?php include view_path() . 'layouts/header.view.php'; ?>   
 
<div class="flex flex-col justify-between mt-32">
     <h2 class="my-6 text-center text-3xl font-extrabold text-gray-700">Login</h2>
          <form action="<?= main_url() ?>/login" method="POST" class="w-80 mx-auto flex flex-col justify-between gap-3">
               
               <div>
                    <input id="email" name="email" type="text" autocomplete="email" value="<?= old('email') ?>" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email">
                    <?php if (session()->hasFlash('email_errors')): ?>
                         <p class="text-xs text-red-500">
                              <?= session()->getFlash('email_errors')[0]; ?>
                         </p>
                    <?php endif; ?>
               </div>

               <div>
                    <input id="password" name="password" type="password" autocomplete="password" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                    <?php if (session()->hasFlash('password_errors')): ?>
                         <p class="text-xs text-red-500">
                              <?= session()->getFlash('password_errors')[0]; ?>
                         </p>
                    <?php endif; ?>
               </div>

               <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                         <input type="checkbox" class="rounded-none h-3 w-3 text-indigo-600">
                         <span class="ml-2 text-xs text-gray-700 font-bold">Remember me</span>
                    </label>
                     <p class="text-right text-xs text-gray-700 font-medium">
                         <a href="#" class="underline hover:text-indigo-800">Forgot password?</a>
                    </p>
               </div>


               <div>
                    <button type="submit" class="uppercase tracking-widest group w-full py-2 px-4 border border-transparent text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                         Login
                    </button>
               </div>

               <?php if (session()->hasFlash('success')): ?>
                    <div class="w-80 mx-auto bg-green-100 border border-green-400 text-green-700 px-4 py-3">
                         <strong class="font-bold text-xs">Success!</strong>
                         <span class="block sm:inline text-xs"><?= session()->getFlash('success'); ?></span>
                    </div>
               <?php endif; ?>

               <?php if (session()->hasFlash('db_fail')): ?>
                    <div class="w-80 mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3">
                         <strong class="font-bold text-xs">Fail!</strong>
                         <span class="block sm:inline text-xs"><?= session()->getFlash('db_fail'); ?></span>
                    </div>
               <?php endif; ?>


          </form>
     </div>

<?php include view_path() . 'layouts/footer.view.php'; ?>