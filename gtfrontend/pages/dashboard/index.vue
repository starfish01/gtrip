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

                  <div class="list is-hoverable">
                    <a
                      class="list-item"
                      v-for="item in destinationData"
                      :key="item.id"
                      :href="'/dashboard/destination/'+item.id"
                    >{{ item.title }} - {{item.enabled ? 'Enabled' : 'Disabled'}}</a>
                  </div>
                  <template v-if="addDestination">
                    <b-field label="title">
                      <b-input v-model="newdestination.title"></b-input>
                    </b-field>
                    <b-field label="URL">
                      <b-input v-model="newdestination.url"></b-input>
                    </b-field>
                    <b-button
                      :disabled="!newdestination.title.length || !newdestination.url.length"
                      class="mb-5"
                      @click="addDestinationSaveBtn()"
                    >Save</b-button>
                    <b-loading :is-full-page="false" :active.sync="isLoadingNewDestination"></b-loading>
                  </template>
                  <b-button class="mb-5" @click="addDestinationBtn()">
                    <span v-if="addDestination">Cancel</span>
                    <span v-else>Add Destination +</span>
                  </b-button>
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
  data() {
    return {
      addDestination: false,
      newdestination: {
        title: "",
        url: ""
      },
      isLoadingNewDestination: false
    };
  },
  methods: {
    addDestinationBtn() {
      this.addDestination = !this.addDestination;
      if (!this.addDestination) {
        this.newdestination.title = "";
        this.newdestination.url = "";
      }
    },
    addDestinationSaveBtn() {
      this.isLoadingNewDestination = true;
      this.$store
        .dispatch("userData/addNewDestination", this.newdestination)
        .then(data => {
          this.addDestinationBtn();
          this.isLoadingNewDestination = false;
          this.$router.push("/dashboard/destination/" + data);
        })
        .catch(error => {
          this.addDestinationBtn();
          this.isLoadingNewDestination = false;
          this.$buefy.toast.open({
            message: "An Error Occured unable to save new destination",
            type: "is-danger"
          });
        });
    }
  },
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
