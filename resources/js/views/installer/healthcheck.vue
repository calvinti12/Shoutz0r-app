<template>
  <div class="card card-md">
    <div class="card-body text-center py-4 p-sm-4">
      <h1>Healthcheck</h1>
      <p class="text-muted">Make sure all health checks are green before continuing. This ensures Shoutz0r will function correctly.</p>
    </div>

    <div class="hr-text hr-text-center hr-text-spaceless">Healthcheck</div>

    <health-checker
        id="healthcheck"
        ref="healthcheck"
        autoFixButtonClasses="btn btn-primary"
        refreshButtonClasses="btn btn-light"
        refreshButtonText="refresh"
        v-bind:showTitle="false"
        v-bind:showInstallSteps="true"
        :isAllHealthy="healthCheckStateUpdate"
    ></health-checker>
  </div>
</template>

<script>
export default {
  name: "installer-healthcheck-view",

  props: {
    showNextButton: { type: Function },
    showCustomButton: { type: Function }
  },

  mounted() {
    this.showNextButton(false);
    this.showCustomButton(false);
  },

  methods: {
    healthCheckStateUpdate: function(healthy) {
      this.showNextButton(healthy);
    }
  }
};
</script>

<style lang="scss">
#healthcheck {
  padding: 5px;
  margin-top: 5px;
}
</style>
