<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/helpers.php';

$title = 'Inicio';

ob_start();
?>

  <div class="flex h-screen w-screen overflow-hidden">

    <!-- Sidebar Section -->
    <aside class="w-[320px] bg-bg-sidebar border-r border-border-color flex flex-col p-6 px-4 overflow-y-auto">
      <h1 class="text-xl font-bold mb-5 text-text-main">Rick and Morty list</h1>

      <!-- Search and Filter Bar -->
      <div class="flex gap-2 mb-6">
        <div class="relative flex-grow">
          <svg class="w-[18px] h-[18px] fill-text-muted absolute left-[10px] top-1/2 -translate-y-1/2" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
          <input type="text" placeholder="Search or filter results"
            class="w-full py-[10px] pl-9 pr-3 border border-border-color rounded-lg bg-[#f4f4f6] text-[13px] font-sans outline-none placeholder:text-text-muted">
        </div>
        <button class="bg-[#f4f4f6] border border-border-color rounded-lg p-2 cursor-pointer flex items-center justify-center" aria-label="Filter">
          <svg class="w-[18px] h-[18px] fill-text-muted" viewBox="0 0 24 24"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
        </button>
      </div>

      <!-- Starred Characters Category -->
      <div class="mb-6">
        <h2 class="text-[11px] font-semibold text-text-muted tracking-[0.5px] mb-3 pl-1">STARRED CHARACTERS (2)</h2>

        <div class="flex items-center p-3 rounded-xl mb-1 cursor-pointer transition-colors duration-200 hover:bg-[#f4f4f6] bg-accent-purple">
          <img src="https://placeholder.com" alt="Abadango Cluster Princess" class="w-10 h-10 rounded-full object-cover mr-3">
          <div class="flex flex-col flex-grow min-w-0">
            <span class="text-sm font-semibold text-accent-purple-text whitespace-nowrap overflow-hidden text-ellipsis">Abadango Cluster Princess</span>
            <span class="text-xs text-text-muted mt-0.5">Alien</span>
          </div>
          <button class="bg-transparent border-none cursor-pointer p-1" aria-label="Unstar">
            <svg class="w-[18px] h-[18px] fill-heart-active stroke-heart-active stroke-2 transition-colors duration-200" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </button>
        </div>

        <div class="flex items-center p-3 rounded-xl mb-1 cursor-pointer transition-colors duration-200 hover:bg-[#f4f4f6]">
          <img src="https://placeholder.com" alt="Beth Smith" class="w-10 h-10 rounded-full object-cover mr-3">
          <div class="flex flex-col flex-grow min-w-0">
            <span class="text-sm font-semibold text-text-main whitespace-nowrap overflow-hidden text-ellipsis">Beth Smith</span>
            <span class="text-xs text-text-muted mt-0.5">Human</span>
          </div>
          <button class="bg-transparent border-none cursor-pointer p-1" aria-label="Unstar">
            <svg class="w-[18px] h-[18px] fill-heart-active stroke-heart-active stroke-2 transition-colors duration-200" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </button>
        </div>
      </div>

      <!-- Regular Characters Category -->
      <div class="mb-6">
        <h2 class="text-[11px] font-semibold text-text-muted tracking-[0.5px] mb-3 pl-1">CHARACTERS (4)</h2>

        <div class="flex items-center p-3 rounded-xl mb-1 cursor-pointer transition-colors duration-200 hover:bg-[#f4f4f6]">
          <img src="https://placeholder.com" alt="Jerry Smith" class="w-10 h-10 rounded-full object-cover mr-3">
          <div class="flex flex-col flex-grow min-w-0">
            <span class="text-sm font-semibold text-text-main whitespace-nowrap overflow-hidden text-ellipsis">Jerry Smith</span>
            <span class="text-xs text-text-muted mt-0.5">Human</span>
          </div>
          <button class="bg-transparent border-none cursor-pointer p-1" aria-label="Star">
            <svg class="w-[18px] h-[18px] fill-none stroke-heart-inactive stroke-2 transition-colors duration-200" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </button>
        </div>

        <div class="flex items-center p-3 rounded-xl mb-1 cursor-pointer transition-colors duration-200 hover:bg-[#f4f4f6]">
          <img src="https://placeholder.com" alt="Morty Smith" class="w-10 h-10 rounded-full object-cover mr-3">
          <div class="flex flex-col flex-grow min-w-0">
            <span class="text-sm font-semibold text-text-main whitespace-nowrap overflow-hidden text-ellipsis">Morty Smith</span>
            <span class="text-xs text-text-muted mt-0.5">Human</span>
          </div>
          <button class="bg-transparent border-none cursor-pointer p-1" aria-label="Star">
            <svg class="w-[18px] h-[18px] fill-none stroke-heart-inactive stroke-2 transition-colors duration-200" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </button>
        </div>

        <div class="flex items-center p-3 rounded-xl mb-1 cursor-pointer transition-colors duration-200 hover:bg-[#f4f4f6]">
          <img src="https://placeholder.com" alt="Rick Sanchez" class="w-10 h-10 rounded-full object-cover mr-3">
          <div class="flex flex-col flex-grow min-w-0">
            <span class="text-sm font-semibold text-text-main whitespace-nowrap overflow-hidden text-ellipsis">Rick Sanchez</span>
            <span class="text-xs text-text-muted mt-0.5">Human</span>
          </div>
          <button class="bg-transparent border-none cursor-pointer p-1" aria-label="Star">
            <svg class="w-[18px] h-[18px] fill-none stroke-heart-inactive stroke-2 transition-colors duration-200" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </button>
        </div>

        <div class="flex items-center p-3 rounded-xl mb-1 cursor-pointer transition-colors duration-200 hover:bg-[#f4f4f6]">
          <img src="https://placeholder.com" alt="Summer Smith" class="w-10 h-10 rounded-full object-cover mr-3">
          <div class="flex flex-col flex-grow min-w-0">
            <span class="text-sm font-semibold text-text-main whitespace-nowrap overflow-hidden text-ellipsis">Summer Smith</span>
            <span class="text-xs text-text-muted mt-0.5">Human</span>
          </div>
          <button class="bg-transparent border-none cursor-pointer p-1" aria-label="Star">
            <svg class="w-[18px] h-[18px] fill-none stroke-heart-inactive stroke-2 transition-colors duration-200" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Detail Section -->
    <main class="flex-grow py-10 px-[60px] overflow-y-auto">
      <div class="mb-8">
        <div class="relative inline-block mb-4">
          <img src="https://placeholder.com" alt="Abadango Cluster Princess" class="w-20 h-20 rounded-full object-cover">
          <div class="absolute bottom-0 -right-1 bg-white rounded-full p-1 shadow-[0_2px_4px_rgba(0,0,0,0.1)] flex items-center justify-center">
            <svg class="w-[14px] h-[14px] fill-heart-active stroke-heart-active stroke-2" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </div>
        </div>
        <h2 class="text-2xl font-bold text-text-main">Abadango Cluster Princess</h2>
      </div>

      <div class="py-4 border-b border-border-color max-w-[600px]">
        <label class="text-[13px] text-text-muted block mb-1">Specie</label>
        <p class="text-[15px] font-medium text-text-main">Alien</p>
      </div>

      <div class="py-4 border-b border-border-color max-w-[600px]">
        <label class="text-[13px] text-text-muted block mb-1">Status</label>
        <p class="text-[15px] font-medium text-text-main">Alive</p>
      </div>

      <div class="py-4 border-b border-border-color max-w-[600px]">
        <label class="text-[13px] text-text-muted block mb-1">Occupation</label>
        <p class="text-[15px] font-medium text-text-main">Princess</p>
      </div>
    </main>

  </div>

<!-- <div x-data="{ characters: [] }" x-init="characters = await (await $http.get('/api/characters')).data.results">
  <template x-for="char in characters" :key="char.id">
    <p x-text="char.name"></p>
  </template>
</div> -->

<?php
$content = ob_get_clean();
require 'src/layouts/default.php';
