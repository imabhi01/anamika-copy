<template>
  <div>
    <!-- Footer -->
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; Your Website {{year}}</span>
        </div>
      </div>
    </footer>
    <!-- End of Footer -->
  </div>
</template>

<script>
export default {
  name: "Footer",
  props: ['year']
};
</script>

<style lang="scss" scoped>
</style>