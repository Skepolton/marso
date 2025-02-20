<template>
  <v-card>
    <v-data-iterator
      :items="items"
      :items-per-page="this.limit"
      :page="page"
    >
      <template v-slot:default="{ items }">
        <v-container class="pa-2" fluid>
          <v-row dense>
            <v-col
              v-for="item in items"
              :key="item.ID"
              cols="auto"
              md="4"
            >
              <v-card class="pb-3" border flat>

                <v-list-item :subtitle="item.raw.DETAIL_TEXT" class="mb-2">
                  <template v-slot:title>
                    <strong class="text-h6 mb-2">{{ item.raw.NAME }}</strong>
                  </template>
                </v-list-item>

                <div class="d-flex justify-space-between px-4">
                  <v-btn
                    class="text-none"
                    size="small"
                    text="Подробнее"
                    variant="flat"
                    border
                    @click="this.getNewsDetail(item.raw.ID)"
                  >
                  </v-btn>
                </div>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </template>

      <template v-slot:footer="{ page, pageCount, prevPage, nextPage }">
        <div class="d-flex align-center justify-center pa-4">
          <v-btn
            :disabled="this.page === 1"
            density="comfortable"
            text="<"
            variant="tonal"
            rounded
            @click="this.page--; this.getNewsList()"
          ></v-btn>

          <div class="mx-2 text-caption">
            Страница {{ this.page }} из {{ this.pageCount }}
          </div>

          <v-btn
            :disabled="this.page >= this.pageCount"
            density="comfortable"
            text=">"
            variant="tonal"
            rounded
            @click="this.page++; this.getNewsList()"
            
          ></v-btn>
        </div>
      </template>
  
    </v-data-iterator>
  </v-card>
  <v-dialog max-width="50%" v-model="dialogOpen"
  >
  <template v-slot:default="{ isActive }">
    <v-card :title="this.detail.NAME">
      <v-card-text>
        {{this.detail.DETAIL_TEXT}}
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          text="Закрыть"
          @click="isActive.value = false"
        ></v-btn>
      </v-card-actions>
    </v-card>
  </template>
</v-dialog>
</template>

<script>
// @ is an alias to /src
import axios from 'axios';
//axios.defaults.params = {}
export default {
  name: 'news',
  components: {
  },
  data() {
    return {
      limit:6,
      page: 1,
      pageCount:0,
      items: Array(),
      detail:"",
      isLoading:false,
      isLoadingDetail:false,
      dialogOpen:false
    }
  },
  computed: {

  },
  mounted() {
    this.getNewsList();
  },
  methods: {
    async getNewsList() {
      this.isLoading = true;
      let totalPages = Math.round(this.totalItems / this.limit) - 1;
      if (this.page > totalPages) {
        this.page--;
      }
      try {
          const response = await axios.get('/marso.test/rest/getlist/', {
            params: {
                page: this.page,
                limit: this.limit,
            }
          });
          this.items = response.data.ITEMS;
          this.totalItems = response.data.COUNT;
          this.pageCount = Math.round(this.totalItems / this.limit) - 1;
      } catch (e) {
          alert(e)
      } finally {
        this.isLoading = false;
      }
    },
    async getNewsDetail(id) {
      this.isLoadingDetail = true;
      let totalPages = Math.round(this.totalItems / this.limit) - 1;
      if (this.page > totalPages) {
        this.page--;
      }
      try {
          const response = await axios.get('http://172.19.110.3/marso.test/rest/getDetail/', {
            params: {
                id: id,
            }
          });
          this.dialogOpen = true;
          this.detail = response.data.ITEMS[0];
      } catch (e) {
          alert(e)
      } finally {
        this.isLoadingDetail = false;
      }
    },
  }
}
</script>

<style>
</style>
