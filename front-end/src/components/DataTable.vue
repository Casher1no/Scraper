<template>
  <v-card>
    <v-table class="border-bottom mb-5">
      <thead>
      <tr>
        <th class="text-center">Title</th>
        <th class="text-center" @click="console.log('clicked')">Points</th>
        <th class="text-center">Date Created</th>
        <th v-if="auth" class="text-center"></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in stories.data" :key="item.name" class="table-row">
        <td class="font-weight-bold"><a target="_blank" v-bind:href="item.link">{{ item.title }}</a></td>
        <td>{{ item.points }}</td>
        <td>{{ item.date_created }}</td>
        <td>
          <v-btn density="compact" icon="" color="red" @click="deleteStory(item.item_id)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg"
                 viewBox="0 0 16 16">
              <path
                  d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
            </svg>
          </v-btn>
        </td>
      </tr>
      </tbody>
    </v-table>

    <v-pagination
        v-model="pagination.page"
        :length="stories.last_page"
        rounded="circle"
        density="compact"
        total-visible="8"
        @input="fetchStories"
    ></v-pagination>
  </v-card>

</template>

<script>

import {useStore} from "vuex";
import {computed} from "vue";

export default {
  data() {
    return {
      headers: [
        {text: "Title", value: "title"},
        {text: "Points", value: "score"},
        {text: "Created At", value: "created_at"},
      ],
      stories: {
        data: [],
        last_page: 1,
      },
      pagination: {
        page: 1,
        perPage: 10,
      },
      search: "",
    };
  },
  setup() {
    const store = useStore();
    const auth = computed(() => store.state.authenticated)

    return {
      auth
    }
  },
  created() {
    this.fetchStories();
  },
  methods: {
    async deleteStory(storyId) {
      try {
        const response = await fetch(
            `http://localhost/api/story/delete/${storyId}`,
            {
              method: 'POST',
              headers: {'Content-Type': 'application/json'},
              credentials: 'include'
            }
        );

        await this.fetchStories();

        if (!response.ok) {
          throw new Error("There was a problem while deleting a story");
        }
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },

    async fetchStories() {
      try {
        const response = await fetch(
            `http://localhost/api/stories/paginated/${this.pagination.page}/${this.pagination.perPage}`,
            {
              method: 'GET',
              headers: {'Content-Type': 'application/json'},
              credentials: 'include'
            }
        );
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        this.stories = data;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
  },
  watch: {
    'pagination.page': function (newPage, oldPage) {
      if (newPage !== oldPage) {
        // Page has changed, fetch new data
        this.fetchStories();
      }
    }
  }
};
</script>

<style scoped>

</style>