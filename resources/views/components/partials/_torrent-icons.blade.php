<span class="torrent-icons">
    @if ($torrent->seeding)
        <i
            class="{{ config('other.font-awesome') }} fa-arrow-circle-up text-success torrent-icons"
            title="{{ __('torrent.currently-seeding') }}"
        ></i>
    @endif

    @if ($torrent->leeching)
        <i
            class="{{ config('other.font-awesome') }} fa-arrow-circle-down text-danger torrent-icons"
            title="{{ __('torrent.currently-leeching') }}"
        ></i>
    @endif

    @if ($torrent->not_completed)
        <i
            class="{{ config('other.font-awesome') }} fa-do-not-enter text-info torrent-icons"
            title="{{ __('torrent.not-completed') }}"
        ></i>
    @endif

    @if ($torrent->not_seeding)
        <i
            class="{{ config('other.font-awesome') }} fa-thumbs-down text-warning torrent-icons"
            title="{{ __('torrent.completed-not-seeding') }}"
        ></i>
    @endif

    @if (config('other.thanks-system.is-enabled') && isset($torrent->thanks_count))
        <i
            class="{{ config('other.font-awesome') }} fa-heartbeat torrent-icons__thanks"
            title="{{ __('torrent.thanks-given') }}"
        >
            {{ $torrent->thanks_count }}
        </i>
    @endif

    @isset($torrent->comments_count)
        <a href="{{ route('torrents.show', ['id' => $torrent->id]) }}#comments">
            <i
                class="{{ config('other.font-awesome') }} fa-comment-alt-lines torrent-icons__comments"
                title="{{ __('torrent.comments-left') }}"
            >
                {{ $torrent->comments_count }}
            </i>
        </a>
    @endisset

    @if ($torrent->internal)
        <i
            class="{{ config('other.font-awesome') }} fa-magic torrent-icons__internal"
            title="{{ __('torrent.internal-release') }}"
        ></i>
    @endif

    @if ($torrent->personal_release)
        <i
            class="{{ config('other.font-awesome') }} fa-user-plus torrent-icons__personal-release"
            title="Personal Release"
        ></i>
    @endif

    @php
        $alwaysFreeleech = $personalFreeleech || $torrent->freeleech_tokens_exists || auth()->user()->group->is_freeleech || auth()->user()->is_donor || config('other.freeleech')
    @endphp

    @if ($torrent->featured)
        <i
            class="{{ config('other.font-awesome') }} fa-award-simple torrent-icons__featured"
            title="{{
                implode(
                    "\n",
                    array_keys(
                        [
                            'Currently:' => true,
                            __('torrent.featured') . ' - 100% ' . __('torrent.freeleech') . ' + ' . __('torrent.double-upload') => true,
                            "\nAfter feature expires:" => true,
                            __('torrent.personal-freeleech') => $personalFreeleech,
                            __('torrent.freeleech-token') => $torrent->freeleech_tokens_exists,
                            __('torrent.special-freeleech') => auth()->user()->group->is_freeleech || auth()->user()->is_donor,
                            __('torrent.global-freeleech') => config('other.freeleech'),
                            $torrent->free . '% ' . __('common.free') . ($torrent->fl_until !== null ? ' (expires ' . $torrent->fl_until->diffForHumans() . ')' : '') => $torrent->free > 0,
                            __('torrent.global-double-upload') => config('other.doubleup'),
                            __('torrent.special-double_upload') => auth()->user()->group->is_double_upload,
                            '100% ' . __('torrent.double-upload') . ($torrent->du_until !== null ? ' (expires ' . $torrent->du_until->diffForHumans() . ')' : '') => $torrent->doubleup > 0,
                        ],
                        true
                    )
                )
            }}"
        ></i>
    @else
        @if ($alwaysFreeleech || $torrent->free)
            <i
                @class([
                    'torrent-icons__freeleech ' . config('other.font-awesome'),
                    'fa-star' => $alwaysFreeleech || (90 <= $torrent->free && $torrent->fl_until === null),
                    'fa-star-half' => ! $alwaysFreeleech && $torrent->free < 90 && $torrent->fl_until === null,
                    'fa-calendar-star' => ! $alwaysFreeleech && $torrent->fl_until !== null,
                ])
                title="{{
                    implode(
                        "\n",
                        array_keys(
                            [
                                __('torrent.personal-freeleech') => $personalFreeleech,
                                __('torrent.freeleech-token') => $torrent->freeleech_tokens_exists,
                                __('torrent.special-freeleech') => auth()->user()->group->is_freeleech,
                                __('torrent.global-freeleech') => config('other.freeleech'),
                                __('torrent.featured') . ' - 100% ' . __('torrent.freeleech') => $torrent->featured,
                                $torrent->free . '% ' . __('common.free') . ($torrent->fl_until !== null ? ' (expires ' . $torrent->fl_until->diffForHumans() . ')' : '') => $torrent->free > 0,
                            ],
                            true
                        )
                    )
                }}"
            ></i>
        @endif

        @if (config('other.doubleup') || auth()->user()->group->is_double_upload || $torrent->doubleup)
            <i
                class="{{ config('other.font-awesome') }} fa-chevron-double-up torrent-icons__double-upload"
                title="{{
                    implode(
                        "\n",
                        array_keys(
                            [
                                __('torrent.global-double-upload') => config('other.doubleup'),
                                __('torrent.special-double_upload') => auth()->user()->group->is_double_upload,
                                __('torrent.featured') . ' - ' . __('torrent.double-upload') => $torrent->featured,
                                '100% ' . __('torrent.double-upload') . ($torrent->du_until !== null ? ' (expires ' . $torrent->du_until->diffForHumans() . ')' : '') => $torrent->doubleup > 0,
                            ],
                            true
                        )
                    )
                }}"
            ></i>
        @endif
    @endif

    @if ($torrent->refundable || auth()->user()->group->is_refundable)
        <i
            class="{{ config('other.font-awesome') }} fa-percentage"
            title="{{ __('torrent.refundable') }}"
        ></i>
    @endif

    @if ($torrent->sticky)
        <i
            class="{{ config('other.font-awesome') }} fa-thumbtack torrent-icons__sticky"
            title="{{ __('torrent.sticky') }}"
        ></i>
    @endif

    @if ($torrent->highspeed)
        <i
            class="{{ config('other.font-awesome') }} fa-bolt-lightning torrent-icons__highspeed"
            title="{{ __('common.high-speeds') }}"
        ></i>
    @endif

    @if ($torrent->bumped_at?->notEqualTo($torrent->created_at) && $torrent->bumped_at?->isBefore(now()->addDay(2)))
        <i
            class="{{ config('other.font-awesome') }} fa-level-up-alt torrent-icons__bumped"
            title="{{ __('torrent.recent-bumped') }}: {{ $torrent->bumped_at }}"
        ></i>
    @endif

    @if ($torrent->trump_exists)
        <i
            class="{{ config('other.font-awesome') }} fa-skull-crossbones torrent-icons__torrent-trump"
            style="color: lightcoral"
            title="This torrent is trumpable for the following reason: {{ $torrent->trump->reason }}"
        ></i>
    @endif
</span>
