<template>
	<div class="at-timeline__item"
		:class="{
			'at-timeline__item--last': this.lastItem,
			'at-timeline__item--pending': isPendingItem,
			'at-timeline__item--custom': !!this.$slots.dot,
			[`at-timeline__item--${status}`]: status
		}">
		<div class="at-timeline__tail"></div>
		<div class="at-timeline__dot">
			<slot name="dot"></slot>
		</div>
		<div class="at-timeline__content">
			<slot></slot>
		</div>
	</div>
</template>

<script>
export default {
	name: 'AtTimelineItem',
	props: {
		color: {
			type: String,
			default: 'blue'
		},
		lastItem: {
			type: Boolean,
			default: false
		}
	},
	data () {
		return {
			colors: {
				blue: 'default',
				red: 'error',
				green: 'success',
				yellow: 'warning'
			},
			defaultColor: 'blue',
			isLastItem: false,
			isPendingItem: false,
		}
	},
	computed: {
		status () {
			const colorKey = this.color
			const status = this.colors[colorKey] || this.colors[this.defaultColor]

			return status
		}
	}
}
</script>

