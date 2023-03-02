  <?php if (session()->hasFlash('db_fail')): ?>
     <div class="mt-5 max-w-7xl mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3">
          <strong class="font-bold text-xs">Fail!</strong>
          <span class="block sm:inline text-xs"><?= session()->getFlash('db_fail'); ?></span>
     </div>
<?php endif; ?>