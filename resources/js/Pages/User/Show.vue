<template>
  <div class="flex h-screen">
    <div class="sidebar w-100 bg-[#011c3e]" style="min-width: 300px">
      <div class="flex-col row-span-3 m-2 bg-[#002046]">
        <div class="flex p-5">
          <ul class="font-bold flex-1 text-left text-white text-2xl">
            Messages
          </ul>
          <ul class="font-bold flex-1 text-right">
            <font-awesome-icon :icon="['fas', 'ellipsis-v']" class="text-white" />
          </ul>
        </div>
        <div class="pb-7 mx-2">
          <div class="input-group">
            <input type="text" placeholder="Search in the list" class="input-field" />
          </div>
        </div>
      </div>
      <div class="row-span-9">
        <ul>
          <div v-for="messageHistory in messageHistories" :key="messageHistory.id" @click="
              showMessageHistory(
                messageHistory.phoneNum,
                messageHistory.sip,
                messageHistory.history
              )
              " class="m-2 rounded-lg bg-[#002046] text-white hover:bg-orange-600 cursor-pointer hover:text-white">
            <div class="flex w-100 call-list cursor-pointer" v-if="messageHistory.id % 2 == 0">
              <div class="icon-bg-call m-3" style="background-color: orangered; border-radius: 80%">
                <font-awesome-icon icon="user" class="font-semibold my-3 icon-style-call text-white"
                  style="color: white; background-color: orangered; border-radius: 80%"
                  :style="{ width: '3rem', height: '1.5rem' }" />
              </div>
              <div class="flex flex-col justify-center">
                <p class="font-bold text-left">
                  {{ messageHistory.phoneNum }}
                </p>
                <p class="text-sm text-left">{{ messageHistory.sip }}</p>
              </div>
            </div>
          </div>
        </ul>
      </div>
    </div>
    <div v-if="showDetail" class="w-full flex flex-col bg-gray-400 h-[calc(100vh)]">
      <div class="h-15 min-h-10 flex p-3 pb-0 ml-2 mt-5 mb-2">
        <div class="icon-bg-call-nav" style="background-color: orangered; border-radius: 80%">
          <font-awesome-icon icon="user" class="font-semibold my-2 icon-style-call text-white"
            style="color: white; background-color: orangered; border-radius: 80%"
            :style="{ width: '2.5rem', height: '1.7rem' }" />
        </div>
        <div class="flex flex-col justify-center">
          <h1 class="font-bold ml-3 text-left text-white">{{ phoneNumber }}</h1>
          <h1 class="font-light ml-3 text-xs-1  text-white">{{ sipAddress }}</h1>
        </div>
        <div class="flex-grow"></div>
        <div class="flex items-center">
          <div class="icon-bg-call-2 m-1" style="background-color: orangered; border-radius: 80%">
            <font-awesome-icon :icon="['fas', 'video']" class="font-semibold my-2 icon-style-call text-white"
              style="color: white; background-color: orangered; border-radius: 80%"
              :style="{ width: '2.8rem', height: '1.5rem' }" />
          </div>
          <div class="icon-bg-call-2 m-1 ml-3" style="background-color: orangered; border-radius: 80%">
            <font-awesome-icon :icon="['fas', 'phone']" class="font-semibold my-2 icon-style-call text-white"
              style="color: white; background-color: orangered; border-radius: 80%"
              :style="{ width: '2.8rem', height: '1.5rem' }" />
          </div>
        </div>
      </div>
      <div class="grid grid-cols-3 my-3 pb-3">
        <div class="col-start-2 col-span-2 input-group mr-3">
          <input type="text" placeholder="Search messages" class="input-field" />
        </div>
      </div>
      <div class="overflow-y-auto grow border-inherit" style="background-color:#ffffff;">
        <div v-for="it in messageData" :key="it.message_id" class="my-4 p-2">
          <div v-if="it.user === '1'" class="flex justify-end mr-7">
            <div class="w-fit p-4 text-sm"
              :style="{ backgroundColor: it.type === 'message' ? '#001835' : '#f1f1f1', borderRadius: it.type === 'message' ? '10px 10px 0 10px' : '0 10px 10px 10px' }">
              <div v-if="it.type === 'image'">
                <image :src="it.value" style="max-width: 15vw; height: auto;" />
              </div>
              <div v-else-if="it.type === 'video'">
                <video :src="it.value" controls style="max-width: 15vw; height: auto;"></video>
              </div>
              <div v-else>
                <span style="color: white; font-size: 20px;">{{ it.value }}</span>
              </div>
            </div>
          </div>
          <div v-else class="flex justify-start ml-7">
            <div class="w-fit p-4 text-sm"
              :style="{ backgroundColor: it.type === 'message' ? '#0f82ff' : '#f1f1f1', borderRadius: it.type === 'message' ? '10px 10px 0 10px' : '0 10px 10px 10px' }">
              <div v-if="it.type === 'image'">
                <img :src="it.value" style="max-width: 15vw; height: auto;" />
              </div>
              <div v-else-if="it.type === 'video'">
                <video :src="it.value" controls style="max-width: 15vw; height: auto;"></video>
              </div>
              <div v-else>
                <span style="color: white; font-size: 20px;">{{ it.value }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="input-container" style="height: 10vh; position: relative;">
        <div v-if="isVisibleMenu == true"
          class="flex flex-col absolute gap-2 w-[180px] h-[130px] overflow-y-auto bottom-[80px] left-0 border shadow-lg rounded-lg bg-white">
          <div class="w-full py-2 pl-6 pt-4 flex justify-start items-center hover:bg-gray-300 text-lg cursor-pointer">
            <v-btn :loading='isSelecting' @click="handleFileImport"
              class="icon-button rounded-full  hover:bg-gray-200 mr-2 p-2">
              <font-awesome-icon icon="user" class="mr-3" />
              Document
            </v-btn>
            <input ref="uploader" type="file" style="display: none" @change="onFileChanged" />
          </div>
          <div
            class="w-full py-2 pl-6 pt-1 flex justyfy-start items-center rounded-full hover:bg-gray-300 text-lg cursor-pointer">
            <v-btn :loading='isSelecting' @click="handleFileImport"
              class="icon-button rounded-full hover:bg-gray-200 mr-2 p-2">
              <font-awesome-icon icon="user" class="mr-3" />
              Photos
            </v-btn>
            <input ref="uploader" type="file" style="display: none" @change="onFileChanged" />
          </div>
        </div>
        <button @click="toggleMenu" class="icon-button rounded-full hover:bg-orange-600 mr-2 p-2"
          :class="{ 'bg-gray-200': isVisibleMenu }">
          <svg :class="{ 'rotate1': isVisibleMenu, 'rotate2': !isVisibleMenu }" transform="rotate(45)"
            viewBox="0 0 24 24" height="24" width="24" preserveAspectRatio="xMidYMid meet" class="" fill="none">
            <title>attach-menu-plus</title>
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M20.5 13.2501L20.5 10.7501L13.25 10.7501L13.25 3.5L10.75 3.5L10.75 10.7501L3.5 10.7501L3.5 13.2501L10.75 13.2501L10.75 20.5L13.25 20.5L13.25 13.2501L20.5 13.2501Z"
              fill="white"></path>
          </svg>
        </button>
        <input type="text" v-model="inputMessage" @keypress="onEnter" placeholder="Your input"
          class="input-field border-2 border-slate-500" />
        <button class="icon-button">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
            class="w-6 h-6">
            <path d="M12 14a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" />
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 14c-2.34 0-4.5 1.08-5.89 2.89l-1.34 1.77L5.11 20H18.89l-.66-1.34-1.34-1.77C16.5 15.08 14.34 14 12 14z" />
          </svg>
        </button>
      </div>
      <div
        style="background-color: #ffffff; height: 4vh; font-size: 20px; color: white; font-weight: bold; padding: 5px;">
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";
import 'tailwindcss/tailwind.css';

import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(fas);

let id = 0;
let message_id = 0;
const showDetail = ref(false);
const phoneNumber = ref("");
const sipAddress = ref("");
const histories = ref([]);
const inputMessage = ref("");
const isVisibleMenu = ref(false);
const isSelecting = ref(false);
const selectedFile = ref(null);


function toggleMenu() {
  isVisibleMenu.value = !isVisibleMenu.value;
}

function showMessageHistory(number, sip, history) {
  showDetail.value = true;
  phoneNumber.value = number;
  sipAddress.value = sip;
  histories.value = history;
  inputMessage.value = "";
}

const m = ref('');
function onEnter(event) {
  if (event.key === "Enter") {
    axios.post('/vue-message', { message: event.target.value }).then(response => {
      m.value = response.data.message; // Assign the response data to the "m" variable
    }).then(() => {
      inputMessage.value = "";
    }).catch(error => {
      console.error('Error fetching message:', error);
    });
  }
}

// function creation
const messageData = ref([]);

let interval = setInterval(() => {
  axios.get('/get-message')
    .then(response => {
      // Update the value of m with the response data
      messageData.value = response.data;
    })

}, 200);

var messageHistories = ref([
  {
    id: id++,
    phoneNum: +5512981437500,
    sip: "+5512981437500@12048.css.net",
    history: [
      {
        message_id: message_id++,
        message_date: "2024-03-15 11-17 AM",
        content: "Hello Mr. Rodrigo!, how are you?",
        type: "1",
        contentType: "message",
      },
    ],
  },
]);

function handleFileImport() {
  isSelecting.value = true;
  window.addEventListener("focus", () => {
    isSelecting.value = false;
  }, { once: true });
  document.querySelector('input[type="file"]').click();
}

const Media = ref('');
function onFileChanged(event) {
  selectedFile.value = event.target.files[0];
  if (selectedFile.value) {
    let contentType = getContentType(selectedFile.value.type);
    let fileName = encodeURIComponent(selectedFile.value.name);
    if (contentType == "video") {
      axios.post('/vueVideo-message', { message: fileURL }).then(response => {
        Media.value = response.data.message; // Assign the response data to the "m" variable
      }).catch(error => {
        console.error('Error fetching message:', error);
      });
    } else {
      axios.post('/vueMedia-message', { message: fileURL }).then(response => {
        Media.value = response.data.message; // Assign the response data to the "m" variable
      }).catch(error => {
        console.error('Error fetching message:', error);
      });
    }
  }
}

function getContentType(fileType) {
  let contentType = "document";
  if (fileType.startsWith("image/")) {
    contentType = "image";
  } else if (fileType.startsWith("video/")) {
    contentType = "video";
  } else if (fileType.startsWith("audio/")) {
    contentType = "audio";
  }
  return contentType;
}
</script>

<style lang="scss">
input:focus {
  border: 1px solid;
  border-color: orange;
}

.input-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  max-width: 1100px;
  /* Set the maximum width as needed */
  margin: 0 auto;
  /* Center the input container */
}

.input-field {
  width: 95%;
  /* Reduce the width of the input field */
  padding: 10px;
  /* Add padding to the input field */
  box-sizing: border-box;
  /* Include padding in the width */
}

.icon-button {
  background: none;
  border: none;
  padding: 5px;
  cursor: pointer;
}

.rotate1 {
  transform: rotate(135deg);
  transition: transform 0.2s ease;
  /* Adjust the duration and timing function as needed */
}

.rotate2 {
  transform: rotate(-0deg);
  transition: transform 0.2s ease;
  /* Adjust the duration and timing function as needed */
}
</style>