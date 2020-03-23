<template>
  <section class="section">
    <div class="container">
      <h2 class="title is-3 has-text-grey">Destination</h2>
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="/dashboard">Dashboard</a></li>
          <li class="is-active">
            <a href="#" aria-current="page">Title</a>
          </li>
        </ul>
      </nav>

      <div class="columns is-touch">
        <div class="column">
          <div class="card">
            <div class="card-content">
              <div class="media">
                <div class="media-content">
                  <p class="title is-4">{{ destinationData.title }}</p>
                </div>
              </div>

              <div class="content">
                <span class="db">Enabled: {{ destinationData.enabled }}</span>
                <span class="db">Found Items:</span>
                <span class="db">URL: <a :href="destinationData.url" target="_blank">{{ destinationData.url }}</a></span>
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
                  <p class="title is-4">Key Words</p>
                </div>
              </div>

              <div class="content"></div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="card">
            <div class="card-content">
              <div class="media">
                <div class="media-content">
                  <p class="title is-4">Fliter Out</p>
                </div>
              </div>

              <div class="content"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";

export default {
  middleware: "auth",
  methods: {
    ...mapMutations({ setSingleDestination: "userData/setSingleDestination" })
  },
  computed: {
    ...mapGetters({
      destinationData: "userData/getSingleDestinationData"
    })
  },
  created() {
    this.setSingleDestination(this.$route.params.id);
  }
};
</script>
