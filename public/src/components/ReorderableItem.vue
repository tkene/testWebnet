<script setup>
defineProps({
  position: {
    type: Number,
    required: true
  },
  canMoveUp: {
    type: Boolean,
    default: true
  },
  canMoveDown: {
    type: Boolean,
    default: true
  },
  delay: {
    type: Number,
    default: 0
  }
})

defineEmits(['move-up', 'move-down'])
</script>

<template>
  <div
    class="reorderable-item"
    :style="{ '--delay': delay + 's' }"
  >
    <div class="item-controls">
      <button
        @click="$emit('move-up')"
        :disabled="!canMoveUp"
        class="control-btn up-btn"
        :class="{ 'disabled': !canMoveUp }"
      >
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M18 15l-6-6-6 6"/>
        </svg>
      </button>
      <div class="position-badge">
        {{ position }}
      </div>
      <button
        @click="$emit('move-down')"
        :disabled="!canMoveDown"
        class="control-btn down-btn"
        :class="{ 'disabled': !canMoveDown }"
      >
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M6 9l6 6 6-6"/>
        </svg>
      </button>
    </div>
    
    <div class="item-content">
      <slot></slot>
    </div>
  </div>
</template>

<style scoped>
.reorderable-item {
  background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
  border-radius: 12px;
  padding: 0.75rem 1rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  box-shadow: 
    0 2px 8px rgba(0, 0, 0, 0.06),
    0 1px 3px rgba(0, 0, 0, 0.04);
  border: 1px solid rgba(0, 0, 0, 0.05);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  animation: slideIn 0.4s ease-out backwards;
  animation-delay: var(--delay);
  cursor: default;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.reorderable-item:hover {
  transform: translateY(-2px);
  box-shadow: 
    0 8px 24px rgba(102, 126, 234, 0.15),
    0 4px 12px rgba(0, 0, 0, 0.08);
  border-color: rgba(102, 126, 234, 0.2);
}

/* Contrôles de déplacement */
.item-controls {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.35rem;
}

.control-btn {
  width: 28px;
  height: 28px;
  border-radius: 8px;
  border: none;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.control-btn svg {
  width: 12px;
  height: 12px;
}

.control-btn:hover:not(.disabled) {
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.control-btn:active:not(.disabled) {
  transform: scale(0.95);
}

.control-btn.disabled {
  opacity: 0.4;
  cursor: not-allowed;
  box-shadow: none;
}

.position-badge {
  width: 26px;
  height: 26px;
  border-radius: 8px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.75rem;
  box-shadow: 0 2px 8px rgba(102, 126, 234, 0.25);
}

.item-content {
  flex: 1;
}

@media (max-width: 640px) {
  .reorderable-item {
    padding: 0.65rem 0.85rem;
    gap: 0.85rem;
  }
}
</style>

