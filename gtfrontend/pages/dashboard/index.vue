<template>
  <section class="section">
    <div class="container">
      <h2 class="title is-3 has-text-grey">Dashboard</h2>

      <template v-if="!destinationData">
        <progress class="progress is-small is-primary" max="100">15%</progress>
      </template>

      <template v-else>
        <div class="columns is-touch">
          <div class="column">
            <div class="card">
              <div class="card-content">
                <div class="media">
                  <div class="media-content">
                    <p class="title is-4">Destinations</p>
                  </div>
                </div>

                <div class="content">
                  <span class="db">Total: {{ destinationData.length }}</span>
                  <span class="db">Enabled: {{ enabledDestinations }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="column">
            <div class="card">
              <div class="card-content">
                <div class="media">
                  <div class="media-content">
                    <p class="title is-4">Found</p>
                  </div>
                </div>

                <div class="content">
                  <span class="db">Found Items:</span>
                  <span class="db">Notified Items:</span>
                  <span class="db">Filtered out Items:</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="columns is-touch">
          <div class="column">
            <div class="card">
              <div class="card-content">
                <div class="media">
                  <div class="media-content">
                    <p class="title is-4">Destinations</p>
                  </div>
                </div>

                <div class="content">
                  <b-button class="mb-5">Add Destination +</b-button>
                  <div class="list is-hoverable">
                    <a
                      class="list-item"
                      v-for="item in destinationData"
                      :key="item.id"
                      :href="'/dashboard/destination/'+item.id"
                    >{{ item.title }}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </div>
  </section>
</template>

    </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  middleware: "auth",
  methods: {},
  computed: {
    ...mapGetters({
      destinationData: "userData/getDestinationData",
      enabledDestinations: "userData/getEnabledDestinations"
    })
  },
  created() {
    this.$store.dispatch("userData/getUserDestinationData");
  }
};
</script>
