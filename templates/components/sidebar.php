<div class='flex flex-col md:flex-row gap-6'>
  <aside class='w-full md:w-1/4 text-sm text-gray-600 bg-gray-50 p-4 rounded'>
    <p class='font-semibold mb-2'>Sidebar</p>
    <ul class='space-y-1 text-blue-600 underline'>
      <li><a href='/'>Home</a></li>
      <li><a href='/about'>About</a></li>
    </ul>
  </aside>
  <section class='w-full md:w-3/4'><?= $content ?></section>
</div>