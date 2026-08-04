<?php


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/helpers.php';

$title = 'Inicio';

ob_start();
?>

  <div x-data="charactersApp()" class="grid h-screen w-screen overflow-hidden lg:grid-cols-[350px_1fr]">

    <!-- Sidebar Section -->
    <aside class="min-w-0 min-h-0 overflow-hidden bg-bg-sidebar border-r border-border-color flex flex-col p-6 px-4">
      <h1 class="text-xl font-bold mb-5 text-text-main">Rick and Morty list</h1>

      <!-- Search and Filter Bar -->
      <div x-ref="searchBar" class="flex mb-6 items-center">
        <div class="relative flex-grow">
          <svg class="w-[18px] h-[18px] fill-text-muted absolute left-[10px] top-1/2 -translate-y-1/2" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
          <input type="text" placeholder="Search or filter results" x-model="search" @input="onSearchInput"
            class="w-full py-[10px] pl-9 pr-3 border-0 border-border-color rounded-l-lg bg-[#f4f4f6] text-[13px] font-sans outline-none placeholder:text-text-muted">
        </div>
        <div class="p-2 bg-[#f4f4f6] rounded-r-lg">
          <button @click="openFilter = !openFilter"
            class="border-0 rounded-lg p-1 cursor-pointer flex items-center justify-center transition-colors duration-200"
            :class="openFilter ? 'bg-accent-purple border-accent-purple' : 'bg-[#f4f4f6]'" >
            <i data-lucide="sliders-vertical" class="w-4 h-4 text-[#7C5CFA]"></i>
          </button>
        </div>
      </div>

      <h2 class="text-[11px] font-semibold text-text-muted tracking-[0.5px] mb-3 pl-1">
        <span x-text="selectedFilter === 'all' ? 'CHARACTERS' : selectedFilter.toUpperCase() + ' CHARACTERS'"></span>
        (<span x-text="totalCount"></span>)
      </h2>

      <!-- Characters List -->
      <div x-ref="scrollContainer" class="flex-1 overflow-y-auto">

        <div x-show="loading" class="flex items-center justify-center py-8">
          <svg class="animate-spin w-6 h-6 text-[#7C5CFA]" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
          </svg>
        </div>

        <template x-for="char in characters" :key="char.id">
          <div @click="selected = char"
            class="flex items-center p-3 rounded-xl mb-1 cursor-pointer transition-colors duration-200 hover:bg-[#f4f4f6]"
            :class="selected?.id === char.id ? 'bg-accent-purple' : ''">
            <img :src="char.image" :alt="char.name" class="w-10 h-10 rounded-full object-cover mr-3">
            <div class="flex flex-col flex-grow min-w-0">
              <span class="text-sm font-semibold whitespace-nowrap overflow-hidden text-ellipsis"
                :class="selected?.id === char.id ? 'text-accent-purple-text' : 'text-text-main'"
                x-text="char.name"></span>
              <span class="flex items-center gap-1.5 text-xs text-text-muted mt-0.5 min-w-0">
                <span class="flex items-center gap-1 shrink-0">
                  <span class="w-1.5 h-1.5 rounded-full" :class="statusColor(char.status)"></span>
                  <span x-text="char.status"></span>
                </span>
                <span class="shrink-0">|</span>
                <span class="truncate" x-text="char.species"></span>
              </span>
              <span class="text-xs text-text-muted mt-0.5 truncate" x-text="char.location?.name"></span>
            </div>
            <div class="rounded-full p-1 transition-colors duration-200"
              :class="selected?.id === char.id && isProtagonist(char.id) ? 'bg-white shadow-[0_2px_4px_rgba(0,0,0,0.1)]' : ''">
              <svg class="w-[18px] h-[18px] stroke-2 transition-colors duration-200" viewBox="0 0 24 24"
                :class="isProtagonist(char.id) ? 'fill-[#FF4D67] stroke-[#FF4D67]' : 'fill-none stroke-[#B6BBCB]'">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
            </div>
          </div>
        </template>

        <p x-show="!characters.length && !loading" x-cloak class="text-sm text-text-muted text-center py-4">
          No characters found
        </p>

        <div x-show="loadingMore" class="flex items-center justify-center py-4">
          <svg class="animate-spin w-5 h-5 text-[#7C5CFA]" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
          </svg>
        </div>

        <div x-ref="sentinel" x-show="paginationType === 'infinite'" class="h-px"></div>
      </div>

      <div x-show="totalPages > 1 && !loading && paginationType === 'normal'" class="flex items-center justify-center gap-3 py-3 border-t border-border-color">
        <button @click="goToPage(page - 1)" :disabled="page <= 1"
          class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cursor-pointer"
          :class="page <= 1 ? 'text-gray-300 cursor-default' : 'text-[#7C5CFA] hover:bg-[#EEE3FF]'">
          Prev
        </button>
        <span class="text-sm text-gray-500">
          <span x-text="page"></span> / <span x-text="totalPages"></span>
        </span>
        <button @click="goToPage(page + 1)" :disabled="page >= totalPages"
          class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cursor-pointer"
          :class="page >= totalPages ? 'text-gray-300 cursor-default' : 'text-[#7C5CFA] hover:bg-[#EEE3FF]'">
          Next
        </button>
      </div>
    </aside>

    <!-- Main Detail Section (lg+) -->
    <main class="hidden lg:block min-w-0 py-10 px-[60px] overflow-y-auto">
      <template x-if="selected">
        <div>
            <div class="flex items-center gap-3 mb-8">
              <div class="relative inline-block">
                <img :src="selected.image" :alt="selected.name" class="w-20 h-20 rounded-full object-cover">
                <div class="absolute bottom-0 -right-1 bg-white rounded-full p-1 shadow-[0_2px_4px_rgba(0,0,0,0.1)] flex items-center justify-center">
                  <svg class="w-[14px] h-[14px] stroke-2" viewBox="0 0 24 24"
                    :class="isProtagonist(selected.id) ? 'fill-[#63D838] stroke-[#63D838]' : 'fill-none stroke-[#B6BBCB]'">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                  </svg>
                </div>
              </div>
              <div class="flex-1">
                <h2 class="text-2xl font-bold text-text-main" x-text="selected.name"></h2>
              </div>
              <button @click="softDelete(selected.id)" class="p-2 rounded-lg hover:bg-red-50 transition-colors cursor-pointer" title="Remove">
                <svg class="w-5 h-5 text-red-400 hover:text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                  <line x1="10" y1="11" x2="10" y2="17"/>
                  <line x1="14" y1="11" x2="14" y2="17"/>
                </svg>
              </button>
            </div>

          <div class="py-4 border-b border-border-color max-w-[600px]">
            <label class="text-[13px] text-text-muted block mb-1">Specie</label>
            <p class="text-[15px] font-medium text-text-main" x-text="selected.species"></p>
          </div>

          <div class="py-4 border-b border-border-color max-w-[600px]">
            <label class="text-[13px] text-text-muted block mb-1">Status</label>
            <p class="text-[15px] font-medium text-text-main" x-text="selected.status"></p>
          </div>

          <div class="py-4 border-b border-border-color max-w-[600px]">
            <label class="text-[13px] text-text-muted block mb-1">Gender</label>
            <p class="text-[15px] font-medium text-text-main" x-text="selected.gender"></p>
          </div>
        </div>
      </template>
    </main>

    <!-- Detail Modal (below lg) -->
    <template x-if="selected">
      <div class="fixed inset-0 z-50 lg:hidden">
        <div class="absolute inset-0 bg-black/40" @click="selected = null"></div>
        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-2xl p-6 max-h-[80vh] overflow-y-auto">
          <div class="flex justify-between items-start mb-6">
            <div class="flex items-center gap-4">
              <div class="relative inline-block">
                <img :src="selected.image" :alt="selected.name" class="w-16 h-16 rounded-full object-cover">
                <div class="absolute bottom-0 -right-1 bg-white rounded-full p-1 shadow-[0_2px_4px_rgba(0,0,0,0.1)] flex items-center justify-center">
                  <svg class="w-[12px] h-[12px] stroke-2" viewBox="0 0 24 24"
                    :class="isProtagonist(selected.id) ? 'fill-[#63D838] stroke-[#63D838]' : 'fill-none stroke-[#B6BBCB]'">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                  </svg>
                </div>
              </div>
              <div>
                <h2 class="text-lg font-bold text-text-main" x-text="selected.name"></h2>
                <span class="text-xs text-text-muted" x-text="selected.species"></span>
              </div>
            </div>
            <button @click="selected = null" class="p-1 cursor-pointer">
              <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"/>
              </svg>
            </button>
          </div>
          <div class="flex justify-end mb-2">
            <button @click="softDelete(selected.id)" class="p-2 rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
              </svg>
            </button>
          </div>

          <div class="py-3 border-t border-gray-100">
            <label class="text-[12px] text-text-muted block mb-0.5">Species</label>
            <p class="text-sm font-medium text-text-main" x-text="selected.species"></p>
          </div>
          <div class="py-3 border-t border-gray-100">
            <label class="text-[12px] text-text-muted block mb-0.5">Status</label>
            <p class="text-sm font-medium text-text-main" x-text="selected.status"></p>
          </div>
          <div class="py-3 border-t border-gray-100">
            <label class="text-[12px] text-text-muted block mb-0.5">Gender</label>
            <p class="text-sm font-medium text-text-main" x-text="selected.gender"></p>
          </div>
        </div>
      </div>
    </template>

    <!-- FILTER CARD -->
    <div x-ref="filterCard"
         x-show="openFilter"
         x-cloak
         x-transition.origin.top.right
         @click.outside="openFilter = false"
         @resize.window="updateFilterPos"
         class="fixed z-50 bg-white rounded-2xl shadow-xl border border-gray-100 p-5 w-[302px]">
        <h4 class="text-[11px] font-semibold text-gray-500 mb-2">Character</h4>
        <div class="flex gap-2">
            <button @click="selectedFilter = 'all'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedFilter === 'all' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">All</button>
            <button @click="selectedFilter = 'starred'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedFilter === 'starred' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">Starred</button>
            <button @click="selectedFilter = 'others'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedFilter === 'others' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">Others</button>
        </div>
        <h4 class="text-[11px] font-semibold text-gray-500 mt-6 mb-2">Specie</h4>
        <div class="flex gap-2">
            <button @click="selectedSpecie = 'all'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedSpecie === 'all' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">All</button>
            <button @click="selectedSpecie = 'human'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedSpecie === 'human' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">Human</button>
            <button @click="selectedSpecie = 'alien'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedSpecie === 'alien' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">Alien</button>
        </div>
        <h4 class="text-[11px] font-semibold text-gray-500 mt-6 mb-2">Status</h4>
        <div class="flex gap-2">
            <button @click="selectedStatus = 'all'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedStatus === 'all' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">All</button>
            <button @click="selectedStatus = 'alive'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedStatus === 'alive' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">Alive</button>
            <button @click="selectedStatus = 'dead'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedStatus === 'dead' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">Dead</button>
        </div>
        <h4 class="text-[11px] font-semibold text-gray-500 mt-6 mb-2">Gender</h4>
        <div class="flex gap-2">
            <button @click="selectedGender = 'all'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedGender === 'all' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">All</button>
            <button @click="selectedGender = 'female'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedGender === 'female' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">Female</button>
            <button @click="selectedGender = 'male'; dirtyFilter = true"
                class="flex-1 h-9 rounded-lg border text-sm font-medium transition-colors cursor-pointer"
                :class="selectedGender === 'male' ? 'bg-[#EEE3FF] text-[#7C5CFA] border-[#EEE3FF]' : 'border-gray-200 hover:bg-gray-50'">Male</button>
        </div>
        <button @click="applyFilters()" class="mt-6 w-full h-10 rounded-lg text-sm font-medium transition-colors cursor-pointer"
            :class="dirtyFilter ? 'bg-[#8054C7] text-white hover:bg-[#6B3FB5]' : 'bg-[#F3F4F8] text-gray-500'">Filter</button>
    </div>

    <!-- Delete Confirmation Modal -->
    <template x-teleport="body">
      <div x-show="showDeleteModal"
           x-cloak
           class="fixed inset-0 z-[100] flex items-center justify-center">
        <div class="absolute inset-0 bg-black/40" @click="cancelDelete"></div>
        <div class="relative bg-white rounded-2xl shadow-xl p-6 w-[90%] max-w-[360px]">
          <div class="flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
              </svg>
            </div>
            <h3 class="text-lg font-bold text-text-main mb-2">Delete character</h3>
            <p class="text-sm text-text-muted mb-6">
              Are you sure you want to delete <span class="font-semibold text-text-main" x-text="selected?.name"></span>?
            </p>
            <div class="flex gap-3 w-full">
              <button @click="cancelDelete"
                class="flex-1 h-10 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer">
                Cancel
              </button>
              <button @click="confirmDelete"
                class="flex-1 h-10 rounded-lg bg-red-500 text-sm font-medium text-white hover:bg-red-600 transition-colors cursor-pointer">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>

  </div>

<script>
  const PER_PAGE = <?= apiPerPage() ?>;
  const PAGINATION_TYPE = '<?= paginationType() ?>';

  function charactersApp() {
    return {
      characters: [],
      selected: null,
      search: '',
      searchTimeout: null,
      openFilter: false,
      loading: false,
      loadingMore: false,
      showDeleteModal: false,
      dirtyFilter: false,
      page: 1,
      totalPages: 1,
      totalCount: 0,
      selectedFilter: 'all',
      selectedSpecie: 'all',
      selectedStatus: 'all',
      selectedGender: 'all',
      protagonistIds: [1, 2, 3, 4, 5],
      paginationType: PAGINATION_TYPE,
      sentinelObserver: null,
      isProtagonist(id) {
        return this.protagonistIds.includes(id)
      },
      statusColor(status) {
        if (status === 'Alive') return 'bg-[#63D838]'
        if (status === 'Dead') return 'bg-[#FF4D67]'
        return 'bg-gray-400'
      },
      async init() {
        this.$watch('openFilter', (val) => {
          if (val) {
            this.dirtyFilter = false
            this.updateFilterPos()
          }
        })
        if (PAGINATION_TYPE === 'infinite') {
          this.$nextTick(() => this.setupSentinel())
        }
        await this.fetchCharacters(true)
      },
      setupSentinel() {
        const el = this.$refs.sentinel
        if (!el) return
        this.sentinelObserver = new IntersectionObserver((entries) => {
          if (entries[0].isIntersecting && !this.loading && !this.loadingMore && this.page < this.totalPages) {
            this.loadMore()
          }
        }, { root: this.$refs.scrollContainer })
        this.sentinelObserver.observe(el)
      },
      async loadMore() {
        this.loadingMore = true
        this.page++
        await this.fetchCharacters()
        this.loadingMore = false
      },
      onSearchInput() {
        clearTimeout(this.searchTimeout)
        this.searchTimeout = setTimeout(() => {
          if (this.search.length >= 3 || this.search.length === 0) {
            this.resetAndFetch()
          }
        }, 300)
      },
      applyFilters() {
        this.openFilter = false
        this.resetAndFetch()
      },
      resetAndFetch() {
        this.characters = []
        this.page = 1
        this.fetchCharacters()
      },
      async fetchCharacters(resetSelected = false) {
        const isAppend = this.page > 1
        if (!isAppend) {
          this.characters = []
        }
        this.loading = !isAppend

        const isInfinite = this.paginationType === 'infinite'
        const apiPage = isInfinite ? this.page : Math.floor((this.page - 1) * PER_PAGE / 20) + 1

        const params = new URLSearchParams()
        params.set('page', String(apiPage))
        if (this.selectedFilter === 'starred') params.set('protagonists', '1')
        if (this.selectedSpecie !== 'all') params.set('species', this.selectedSpecie)
        if (this.selectedStatus !== 'all') params.set('status', this.selectedStatus)
        if (this.selectedGender !== 'all') params.set('gender', this.selectedGender)
        if (this.search.length >= 3) params.set('name', this.search)
        const qs = params.toString()
        const url = 'api/characters' + (qs ? '?' + qs : '')
        try {
          const { data } = await this.$http.get(url)

          if (isInfinite) {
            const results = data.results ?? []
            this.totalPages = data.pages ?? 1
            this.totalCount = data.count ?? results.length
            if (isAppend) {
              this.characters = this.characters.concat(results)
            } else {
              this.characters = results
            }
          } else {
            const allResults = data.results ?? []
            this.totalPages = Math.ceil((data.count ?? allResults.length) / PER_PAGE)
            this.totalCount = data.count ?? allResults.length
            const offset = ((this.page - 1) * PER_PAGE) % 20
            const slice = allResults.slice(offset, offset + PER_PAGE)
            if (isAppend) {
              this.characters = this.characters.concat(slice)
            } else {
              this.characters = slice
            }
          }

          const skipSelect = window.innerWidth < 1024 && this.paginationType === 'infinite'
          if (!skipSelect && (resetSelected || !this.selected || !this.characters.find(c => c.id === this.selected.id))) {
            this.selected = this.characters[0] ?? null
          }
        } catch (e) {
          console.error('Failed to fetch characters', e)
        } finally {
          this.loading = false
        }
      },
      goToPage(p) {
        this.page = p
        this.characters = []
        this.fetchCharacters()
      },
      softDelete(id) {
        this.showDeleteModal = true
      },
      cancelDelete() {
        this.showDeleteModal = false
      },
      confirmDelete() {
        const id = this.selected.id
        this.characters = this.characters.filter(c => c.id !== id)
        this.totalCount = this.characters.length
        this.selected = null
        this.showDeleteModal = false
      },
      updateFilterPos() {
        this.$nextTick(() => {
          const bar = this.$refs.searchBar
          const card = this.$refs.filterCard
          if (!bar || !card) return
          const rect = bar.getBoundingClientRect()
          card.style.top = rect.bottom + 'px'
          card.style.left = rect.left + 'px'
          card.style.width = rect.width + 'px'
        })
      }
    }
  }
</script>

<?php
$content = ob_get_clean();
require 'src/layouts/default.php';
