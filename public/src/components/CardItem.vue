<script setup>
defineProps({
  card: {
    type: Object,
    required: true
  },
  sorted: {
    type: Boolean,
    default: false
  },
  delay: {
    type: Number,
    default: 0
  }
})
</script>


<template>
  <div
    class="card-item"
    :class="{ 'sorted': sorted }"
    :style="{ '--delay': delay + 's' }"
  >
    <div class="card-symbol">{{ card.symbol }}</div>
    <div class="card-value">{{ card.value }}</div>
    <div class="card-color">{{ card.color }}</div>
  </div>
</template>

<style scoped>
.card-item {
  background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
  border-radius: 12px;
  padding: 0.75rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.4rem;
  box-shadow: 
    0 2px 8px rgba(0, 0, 0, 0.06),
    0 1px 3px rgba(0, 0, 0, 0.04);
  border: 1px solid rgba(0, 0, 0, 0.05);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  animation: cardAppear 0.4s ease-out backwards;
  animation-delay: var(--delay);
  width: calc(20% - 0.8rem);
  min-width: 80px;
  aspect-ratio: 3/2;
  max-height: 100px;
}

.card-item.sorted {
  border-color: rgba(102, 126, 234, 0.2);
  background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%);
}

@keyframes cardAppear {
  from {
    opacity: 0;
    transform: scale(0.8) rotateY(-10deg);
  }
  to {
    opacity: 1;
    transform: scale(1) rotateY(0deg);
  }
}

.card-item:hover {
  transform: translateY(-4px) scale(1.05);
  box-shadow: 
    0 8px 24px rgba(102, 126, 234, 0.2),
    0 4px 12px rgba(0, 0, 0, 0.1);
  border-color: rgba(102, 126, 234, 0.3);
}

.card-symbol {
  font-size: 1.75rem;
  line-height: 1;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

.card-value {
  font-size: 0.95rem;
  font-weight: 700;
  color: #1a1a2e;
  text-align: center;
}

.card-color {
  font-size: 0.75rem;
  color: #6b7280;
  text-align: center;
}

@media (max-width: 1024px) {
  .card-item {
    width: calc(25% - 0.75rem);
  }
}

@media (max-width: 768px) {
  .card-item {
    width: calc(33.333% - 0.67rem);
    min-width: 70px;
  }
}

@media (max-width: 640px) {
  .card-item {
    width: calc(50% - 0.5rem);
    min-width: 70px;
  }
}
</style>

