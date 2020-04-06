<template>
  <section class="section">
    <div class="container">
      <h2 class="title is-3 has-text-grey">Destination</h2>
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li>
            <a href="/dashboard">Dashboard</a>
          </li>

          <li class="is-active" v-if="!isLoading && destinationData">
            <a href="#" aria-current="page">{{destinationData.title}}</a>
          </li>
        </ul>
      </nav>

      <template v-if="isLoading">
        <progress class="progress is-small is-primary" max="100">15%</progress>
      </template>

      <template v-if="!isLoading && !destinationData">
        <p>Something went wrong :(</p>
        <p>{{error}}</p>
        <p>
          <a href="/dashboard">Click here to return to the dashboard</a>
        </p>
      </template>

      <template v-if="!isLoading && destinationData">
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
                  <span class="db">
                    <b-button @click="isComponentModalActive = true" :type="'is-danger'">Delete</b-button>

                    <b-modal
                      :active.sync="isComponentModalActive"
                      has-modal-card
                      trap-focus
                      aria-role="dialog"
                      aria-modal
                    >
                      <div class="modal-card" style="width: auto">
                        <header class="modal-card-head">
                          <p class="modal-card-title">Do you wish to delete this destination?</p>
                        </header>
                        <section class="modal-card-body">
                          <button
                            class="button"
                            type="button"
                            @click="isComponentModalActive = false"
                          >Cancel</button>
                          <button class="button is-danger" @click="deleteDestination()">Yes</button>
                        </section>
                      </div>
                    </b-modal>
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
                    <div class="list is-hoverable">
                      <div class="list-item" v-for="(item,index) in keyWords" :key="index">
                        <span>{{ item }}</span>
                        <span>
                          <b-button
                            type="is-danger"
                            icon-right="delete"
                            size="is-small"
                            @click="deleteKeyWord(item,'key')"
                            class="is-pulled-right"
                            href
                          ></b-button>
                        </span>
                      </div>
                    </div>
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

                    <div class="list is-hoverable">
                      <div class="list-item" v-for="(item,index) in skipKeys" :key="index">
                        <span>{{ item }}</span>
                        <span>
                          <b-button
                            type="is-danger"
                            icon-right="delete"
                            size="is-small"
                            @click="deleteKeyWord(item,'skip')"
                            class="is-pulled-right"
                            href
                          ></b-button>
                        </span>
                      </div>
                    </div>
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
    return {
      destinationData: null,
      isLoading: true,
      error: null,
      isComponentModalActive: false,
      keyWords: null,
      skipKeys: null
    };
  },
  methods: {
    destinationSwitch() {
      this.$store.dispatch("userData/enabledDisableDestination");
    },
    deleteDestination() {
      this.$store
        .dispatch("userData/deleteDestination", this.destinationData.id)
        .then(data => {
          this.$router.push("/dashboard");
        })
        .catch(error => {
          console.log(error);
          // do something
        });
    },

    deleteKeyWord(item, type) {
      this.$store.dispatch("userData/deleteKeyOrFilter", {item, type});
    },

    ...mapMutations({})
  },
  computed: {
    ...mapGetters({})
  },
  created() {
    if (!this.$route.params.id) {
      this.$router.push("/dashboard");
    }
    this.$store
      .dispatch("userData/getSingleDestination", this.$route.params.id)
      .then(data => {
        this.isLoading = false;
        this.destinationData = data[0];

        this.keyWords = data[0].keys.keys.replace(/[\[\]']+/g, "").split(",");
        this.skipKeys = data[0].keys.skip_keys
          .replace(/[\[\]']+/g, "")
          .split(",");
      })
      .catch(error => {
        this.isLoading = false;
        this.error = error;
        // console.log(error);
      });
  }
};
</script>
