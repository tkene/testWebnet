<script setup>
defineProps({
  label: {
    type: String,
    default: ''
  },
  buttonClass: {
    type: String,
    default: 'primary-btn'
  },
  loading: {
    type: Boolean,
    default: false
  },
  loadingText: {
    type: String,
    default: 'Chargement...'
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

defineEmits(['click'])
</script>

<template>
  <button
    :class="['action-btn', buttonClass, { 'loading': loading, 'disabled': disabled }]"
    :disabled="disabled || loading"
    @click="$emit('click', $event)"
  >
    <span v-if="!loading">{{ label }}</span>
    <span v-else class="loading-text">{{ loadingText }}</span>
    <slot></slot>
  </button>
</template>

<style scoped>
.action-btn {
  padding: 0.875rem 2rem;
  border-radius: 12px;
  border: none;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
  letter-spacing: -0.01em;
}

.action-btn::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.3);
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.action-btn:hover::before {
  width: 300px;
  height: 300px;
}

.primary-btn {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  box-shadow: 
    0 4px 16px rgba(102, 126, 234, 0.4),
    0 2px 8px rgba(102, 126, 234, 0.2);
}

.primary-btn:hover:not(:disabled):not(.disabled) {
  transform: translateY(-2px);
  box-shadow: 
    0 8px 24px rgba(102, 126, 234, 0.5),
    0 4px 12px rgba(102, 126, 234, 0.3);
}

.primary-btn:active:not(:disabled):not(.disabled) {
  transform: translateY(0);
}

.secondary-btn {
  background: rgba(102, 126, 234, 0.1);
  color: #667eea;
  border: 2px solid rgba(102, 126, 234, 0.2);
}

.secondary-btn:hover:not(:disabled):not(.disabled) {
  background: rgba(102, 126, 234, 0.15);
  border-color: rgba(102, 126, 234, 0.3);
  transform: translateY(-2px);
}

.action-btn:disabled,
.action-btn.disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.loading-text {
  display: inline-block;
  animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

@media (max-width: 640px) {
  .action-btn {
    width: 100%;
  }
}
</style>

