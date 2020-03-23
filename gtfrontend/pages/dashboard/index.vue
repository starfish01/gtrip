<template>
  <section class="section">
    <div class="container">
      <h2 class="title is-3 has-text-grey">Dashboard</h2>

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
                  >
                    {{ item.title }}
                  </a>
                </div>
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
                  <p class="title is-4">Items Found</p>
                  <p class="subtitle is-6">Total:</p>
                </div>
              </div>

              <div class="content">
                <div class="list is-hoverable">
                  <a class="list-item">
                    Featured
                  </a>
                  <a class="list-item">
                    All Posts
                  </a>
                  <a class="list-item is-active">
                    Announcements
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  middleware: "auth",
  computed: {
    ...mapGetters({
      destinationData: "userData/getDestinationData",
      enabledDestinations: "userData/getEnabledDestinations"
    })
  }
};
</script>
