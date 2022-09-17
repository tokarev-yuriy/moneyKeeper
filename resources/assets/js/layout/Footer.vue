<template>
  <footer class="py-3 footer">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="mb-4 col-lg-6 mb-lg-0">
          <div
            class="text-sm text-center copyright text-muted"
            :class="'text-lg-start'"
          >
            {{ (new Date().getFullYear()) }}, Money Keeper. Source code available on <a href="https://github.com/tokarev-yuriy/moneyKeeper">GitHub</a>.<br/>
            Code licensed <a href="https://github.com/tokarev-yuriy/moneyKeeper/blob/master/LICENSE.md" target="_blank" rel="license noopener">MIT</a>.
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "app-footer",
};
</script> 
