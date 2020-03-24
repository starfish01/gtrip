<template>
  <section class="section">
    <div class="container">
      <h2 class="title is-3 has-text-grey">Destination</h2>
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li>
            <a href="/dashboard">Dashboard</a>
          </li>
          <li class="is-active">
            <a href="#" aria-current="page">Title</a>
          </li>
        </ul>
      </nav>
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
                    <p class="title is-4">{{ destinationData.title }}</p>
                  </div>
                </div>
                <div class="content">
                  <span
                    class="db"
                  >Destination is Enabled: {{ destinationData.enabled ? 'Yes' : 'No'}}</span>
                  <b-button
                    @click="destinationSwitch"
                    :type="destinationData.enabled ? 'is-warning' : 'is-success' "
                  >{{destinationData.enabled ? 'Disable' : 'Enabled'}} Destination</b-button>

                  <span class="db">Found Items: {{destinationData.found_items.length}}</span>
                  <span class="db">
                    URL:
                    <a :href="destinationData.url" target="_blank">{{ destinationData.url }}</a>
                  </span>
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
                    {{destinationData.keys.keys}}
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
                    {{destinationData.keys.skip_keys}}
                  </div>
                </div>

                <div class="content"></div>
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
                    <p class="title is-4">Found Items</p>

                    <table class="table is-striped">
                      <tr>
                        <th>Title</th>
                        <th>Email Sent</th>
                        <th>Filtered Out</th>
                        <th>Created At</th>
                        <th>Location</th>
                        <th>Distance</th>
                        <th>Suburb</th>
                      </tr>

                      <tr v-for="item in destinationData.found_items" :key="item.id">
                        <td>
                          <a :href="item.url" target="_blank">{{item.title}}</a>
                        </td>
                        <td>{{item.email_sent ? 'yes' : 'no'}}</td>
                        <td>{{item.filtered_out ? 'yes' : 'no'}}</td>
                        <td>{{item.createdAt}}</td>
                        <td>{{item.location}}</td>
                        <td>{{item.distance}}</td>
                        <td>{{item.suburb}}</td>
                      </tr>
                    </table>
                  </div>
                </div>

                <div class="content"></div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </div>
  </section>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";

export default {
  middleware: "auth",
  data() {
    return {};
  },
  methods: {
    destinationSwitch() {
      this.$store.dispatch("userData/enabledDisableDestination");
    },
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
