<?php
/*
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace AppBundle\GoogleApi\Contrib;

use AppBundle\GoogleApi\Client;
use AppBundle\GoogleApi\Service\Model;
use AppBundle\GoogleApi\Service\Service;
use AppBundle\GoogleApi\Service\ServiceResource;

  /**
   * The "activities" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $activities = $youtubeService->activities;
   *  </code>
   */
  class ActivitiesServiceResource extends ServiceResource {

    /**
     * Posts a bulletin for a specific channel. (The user submitting the request must be authorized to
     * act on the channel's behalf.) (activities.insert)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part names that you can include in the parameter value are snippet and contentDetails.
     * @param Activity $postBody
     * @param array $optParams Optional parameters.
     * @return Activity
     */
    public function insert($part, Activity $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('insert', array($params));
      if ($this->useObjects()) {
        return new Activity($data);
      } else {
        return $data;
      }
    }
    /**
     * Returns a list of channel activity events that match the request criteria. For example, you can
     * retrieve events associated with a particular channel, events associated with the user's
     * subscriptions and Google+ friends, or the YouTube home page feed, which is customized for each
     * user. (activities.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more activity resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, and contentDetails.
    If the parameter identifies a property that contains child properties, the child properties will be included in the response. For example, in a activity resource, the snippet property contains other properties that identify the type of activity, a display title for the activity, and so forth. If you set part=snippet, the API response will also contain all of those nested properties.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string channelId The channelId parameter specifies a unique YouTube channel ID. The API will then return a list of that channel's activities.
     * @opt_param bool home Set this parameter's value to true to retrieve the activity feed that displays on the YouTube home page for the currently authenticated user.
     * @opt_param string maxResults USE_DESCRIPTION --- channels:list:maxResults
     * @opt_param bool mine Set this parameter's value to true to retrieve a feed of the authenticated user's activities.
     * @opt_param string pageToken USE_DESCRIPTION --- channels:list:pageToken
     * @opt_param string publishedAfter The publishedAfter parameter specifies the earliest date and time that an activity could have occurred for that activity to be included in the API response. If the parameter value specifies a day, but not a time, then any activities that occurred that day will be included in the result set. The value is specified in ISO 8601 (YYYY-MM-DDThh:mm:ss.sZ) format.
     * @opt_param string publishedBefore The publishedBefore parameter specifies the date and time before which an activity must have occurred for that activity to be included in the API response. If the parameter value specifies a day, but not a time, then any activities that occurred that day will be excluded from the result set. The value is specified in ISO 8601 (YYYY-MM-DDThh:mm:ss.sZ) format.
     * @opt_param string regionCode The regionCode parameter instructs the API to return results for the specified country. The parameter value is an ISO 3166-1 alpha-2 country code.
     * @return ActivityListResponse
     */
    public function listActivities($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new ActivityListResponse($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "channelBanners" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $channelBanners = $youtubeService->channelBanners;
   *  </code>
   */
  class ChannelBannersServiceResource extends ServiceResource {

    /**
     * Uploads a channel banner to YouTube. (channelBanners.insert)
     *
     * @param ChannelBannerResource $postBody
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @return ChannelBannerResource
     */
    public function insert(ChannelBannerResource $postBody, $optParams = array()) {
      $params = array('postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('insert', array($params));
      if ($this->useObjects()) {
        return new ChannelBannerResource($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "channels" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $channels = $youtubeService->channels;
   *  </code>
   */
  class ChannelsServiceResource extends ServiceResource {

    /**
     * Returns a collection of zero or more channel resources that match the request criteria.
     * (channels.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more channel resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, contentDetails, statistics, topicDetails, and invideoPromotion.
    If the parameter identifies a property that contains child properties, the child properties will be included in the response. For example, in a channel resource, the contentDetails property contains other properties, such as the uploads properties. As such, if you set part=contentDetails, the API response will also contain all of those nested properties.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string categoryId The categoryId parameter specifies a YouTube guide category, thereby requesting YouTube channels associated with that category.
     * @opt_param string forUsername The forUsername parameter specifies a YouTube username, thereby requesting the channel associated with that username.
     * @opt_param string id The id parameter specifies a comma-separated list of the YouTube channel ID(s) for the resource(s) that are being retrieved. In a channel resource, the id property specifies the channel's YouTube channel ID.
     * @opt_param bool managedByMe Set this parameter's value to true to instruct the API to only return channels managed by the content owner that the onBehalfOfContentOwner parameter specifies. The user must be authenticated as a CMS account linked to the specified content owner and onBehalfOfContentOwner must be provided.
     * @opt_param string maxResults The maxResults parameter specifies the maximum number of items that should be returned in the result set.
     * @opt_param bool mine Set this parameter's value to true to instruct the API to only return channels owned by the authenticated user.
     * @opt_param bool mySubscribers Set this parameter's value to true to retrieve a list of channels that subscribed to the authenticated user's channel.
     * @opt_param string onBehalfOfContentOwner The onBehalfOfContentOwner parameter indicates that the authenticated user is acting on behalf of the content owner specified in the parameter value. This parameter is intended for YouTube content partners that own and manage many different YouTube channels. It allows content owners to authenticate once and get access to all their video and channel data, without having to provide authentication credentials for each individual channel. The actual CMS account that the user authenticates with needs to be linked to the specified YouTube content owner.
     * @opt_param string pageToken The pageToken parameter identifies a specific page in the result set that should be returned. In an API response, the nextPageToken and prevPageToken properties identify other pages that could be retrieved.
     * @return ChannelListResponse
     */
    public function listChannels($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new ChannelListResponse($data);
      } else {
        return $data;
      }
    }
    /**
     * Updates a channel's metadata. (channels.update)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part names that you can include in the parameter value are id and invideoPromotion.
    Note that this method will override the existing values for all of the mutable properties that are contained in any parts that the parameter value specifies.
     * @param Channel $postBody
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner The onBehalfOfContentOwner parameter indicates that the authenticated user is acting on behalf of the content owner specified in the parameter value. This parameter is intended for YouTube content partners that own and manage many different YouTube channels. It allows content owners to authenticate once and get access to all their video and channel data, without having to provide authentication credentials for each individual channel. The actual CMS account that the user authenticates with needs to be linked to the specified YouTube content owner.
     * @return Channel
     */
    public function update($part, Channel $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('update', array($params));
      if ($this->useObjects()) {
        return new Channel($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "guideCategories" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $guideCategories = $youtubeService->guideCategories;
   *  </code>
   */
  class GuideCategoriesServiceResource extends ServiceResource {

    /**
     * Returns a list of categories that can be associated with YouTube channels. (guideCategories.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more guideCategory resource properties that the API response will include. The part names that you can include in the parameter value are id and snippet.
    If the parameter identifies a property that contains child properties, the child properties will be included in the response. For example, in a guideCategory resource, the snippet property contains other properties, such as the category's title. If you set part=snippet, the API response will also contain all of those nested properties.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string hl The hl parameter specifies the language that will be used for text values in the API response.
     * @opt_param string id The id parameter specifies a comma-separated list of the YouTube channel category ID(s) for the resource(s) that are being retrieved. In a guideCategory resource, the id property specifies the YouTube channel category ID.
     * @opt_param string regionCode The regionCode parameter instructs the API to return the list of guide categories available in the specified country. The parameter value is an ISO 3166-1 alpha-2 country code.
     * @return GuideCategoryListResponse
     */
    public function listGuideCategories($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new GuideCategoryListResponse($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "liveBroadcasts" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $liveBroadcasts = $youtubeService->liveBroadcasts;
   *  </code>
   */
  class LiveBroadcastsServiceResource extends ServiceResource {

    /**
     * Binds a YouTube broadcast to a stream or removes an existing binding between a broadcast and a
     * stream. A broadcast can only be bound to one video stream. (liveBroadcasts.bind)
     *
     * @param string $id The id parameter specifies the unique ID of the broadcast that is being bound to a video stream.
     * @param string $part The part parameter specifies a comma-separated list of one or more liveBroadcast resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, contentDetails, and status.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @opt_param string streamId The streamId parameter specifies the unique ID of the video stream that is being bound to a broadcast. If this parameter is omitted, the API will remove any existing binding between the broadcast and a video stream.
     * @return LiveBroadcast
     */
    public function bind($id, $part, $optParams = array()) {
      $params = array('id' => $id, 'part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('bind', array($params));
      if ($this->useObjects()) {
        return new LiveBroadcast($data);
      } else {
        return $data;
      }
    }
    /**
     * Control the slate of the broadacast. (liveBroadcasts.control)
     *
     * @param string $id The id parameter specifies the YouTube live broadcast ID for the resource that is being deleted.
     * @param string $part The part parameter specifies a comma-separated list of one or more liveBroadcast resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, contentDetails, and status.
     * @param array $optParams Optional parameters.
     *
     * @opt_param bool displaySlate The displaySlate parameter specifies whether to enable or disable the slate.
     * @opt_param string offsetTimeMs The offsetTimeMs parameter specifies a point in time in the video when the specified action (e.g. display a slate) is executed. The property value identifies a positive time offset, in milliseconds, from the beginning of the monitor stream. Though measured in milliseconds, the value is actually an approximation, and YouTube will act as closely as possible to that time. If not specified, it indicates that the action should be performed as soon as possible. If your broadcast stream is not delayed, then it should not be specified. However, if your broadcast stream is delayed, then the parameter can specify the time when the operation should be executed. See the Getting started guide for more details. Note: The offset is measured from the time that the testing phase began.
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @return LiveBroadcast
     */
    public function control($id, $part, $optParams = array()) {
      $params = array('id' => $id, 'part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('control', array($params));
      if ($this->useObjects()) {
        return new LiveBroadcast($data);
      } else {
        return $data;
      }
    }
    /**
     * Deletes a broadcast. (liveBroadcasts.delete)
     *
     * @param string $id The id parameter specifies the YouTube live broadcast ID for the resource that is being deleted.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     */
    public function delete($id, $optParams = array()) {
      $params = array('id' => $id);
      $params = array_merge($params, $optParams);
      $data = $this->__call('delete', array($params));
      return $data;
    }
    /**
     * Creates a broadcast. (liveBroadcasts.insert)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part properties that you can include in the parameter value are id, snippet, contentDetails, and status.
     * @param LiveBroadcast $postBody
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @return LiveBroadcast
     */
    public function insert($part, LiveBroadcast $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('insert', array($params));
      if ($this->useObjects()) {
        return new LiveBroadcast($data);
      } else {
        return $data;
      }
    }
    /**
     * Returns a list of YouTube broadcasts that match the API request parameters. (liveBroadcasts.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more liveBroadcast resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, contentDetails, and status.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string broadcastStatus The broadcastStatus parameter filters the API response to only include broadcasts with the specified status.
     * @opt_param string id The id parameter specifies a comma-separated list of YouTube broadcast IDs that identify the broadcasts being retrieved. In a liveBroadcast resource, the id property specifies the broadcast's ID.
     * @opt_param string maxResults The maxResults parameter specifies the maximum number of items that should be returned in the result set. Acceptable values are 0 to 50, inclusive. The default value is 5.
     * @opt_param bool mine The mine parameter can be used to instruct the API to only return broadcasts owned by the authenticated user. Set the parameter value to true to only retrieve your own broadcasts.
     * @opt_param string pageToken The pageToken parameter identifies a specific page in the result set that should be returned. In an API response, the nextPageToken and prevPageToken properties identify other pages that could be retrieved.
     * @return LiveBroadcastList
     */
    public function listLiveBroadcasts($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new LiveBroadcastList($data);
      } else {
        return $data;
      }
    }
    /**
     * Changes the status of a YouTube live broadcast and initiates any processes associated with the
     * new status. For example, when you transition a broadcast's status to testing, YouTube starts to
     * transmit video to that broadcast's monitor stream. (liveBroadcasts.transition)
     *
     * @param string $broadcastStatus The broadcastStatus parameter identifies the state to which the broadcast is changing.
     * @param string $id The id parameter specifies the unique ID of the broadcast that is transitioning to another status.
     * @param string $part The part parameter specifies a comma-separated list of one or more liveBroadcast resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, contentDetails, and status.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @return LiveBroadcast
     */
    public function transition($broadcastStatus, $id, $part, $optParams = array()) {
      $params = array('broadcastStatus' => $broadcastStatus, 'id' => $id, 'part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('transition', array($params));
      if ($this->useObjects()) {
        return new LiveBroadcast($data);
      } else {
        return $data;
      }
    }
    /**
     * Updates a broadcast. For example, you could modify the broadcast settings defined in the
     * liveBroadcast resource's contentDetails object. (liveBroadcasts.update)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part properties that you can include in the parameter value are id, snippet, contentDetails, and status.
    Note that this method will override the existing values for all of the mutable properties that are contained in any parts that the parameter value specifies. For example, a broadcast's privacy status is defined in the status part. As such, if your request is updating a private or unlisted broadcast, and the request's part parameter value includes the status part, the broadcast's privacy setting will be updated to whatever value the request body specifies. If the request body does not specify a value, the existing privacy setting will be removed and the broadcast will revert to the default privacy setting.
     * @param LiveBroadcast $postBody
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @return LiveBroadcast
     */
    public function update($part, LiveBroadcast $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('update', array($params));
      if ($this->useObjects()) {
        return new LiveBroadcast($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "liveStreams" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $liveStreams = $youtubeService->liveStreams;
   *  </code>
   */
  class LiveStreamsServiceResource extends ServiceResource {

    /**
     * Deletes a video stream. (liveStreams.delete)
     *
     * @param string $id The id parameter specifies the YouTube live stream ID for the resource that is being deleted.
     * @param array $optParams Optional parameters.
     */
    public function delete($id, $optParams = array()) {
      $params = array('id' => $id);
      $params = array_merge($params, $optParams);
      $data = $this->__call('delete', array($params));
      return $data;
    }
    /**
     * Creates a video stream. The stream enables you to send your video to YouTube, which can then
     * broadcast the video to your audience. (liveStreams.insert)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part properties that you can include in the parameter value are id, snippet, cdn, and status.
     * @param LiveStream $postBody
     * @param array $optParams Optional parameters.
     * @return LiveStream
     */
    public function insert($part, LiveStream $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('insert', array($params));
      if ($this->useObjects()) {
        return new LiveStream($data);
      } else {
        return $data;
      }
    }
    /**
     * Returns a list of video streams that match the API request parameters. (liveStreams.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more liveStream resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, cdn, and status.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string id The id parameter specifies a comma-separated list of YouTube stream IDs that identify the streams being retrieved. In a liveStream resource, the id property specifies the stream's ID.
     * @opt_param string maxResults The maxResults parameter specifies the maximum number of items that should be returned in the result set. Acceptable values are 0 to 50, inclusive. The default value is 5.
     * @opt_param bool mine The mine parameter can be used to instruct the API to only return streams owned by the authenticated user. Set the parameter value to true to only retrieve your own streams.
     * @opt_param string pageToken The pageToken parameter identifies a specific page in the result set that should be returned. In an API response, the nextPageToken and prevPageToken properties identify other pages that could be retrieved.
     * @return LiveStreamList
     */
    public function listLiveStreams($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new LiveStreamList($data);
      } else {
        return $data;
      }
    }
    /**
     * Updates a video stream. If the properties that you want to change cannot be updated, then you
     * need to create a new stream with the proper settings. (liveStreams.update)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part properties that you can include in the parameter value are id, snippet, cdn, and status.
    Note that this method will override the existing values for all of the mutable properties that are contained in any parts that the parameter value specifies. If the request body does not specify a value for a mutable property, the existing value for that property will be removed.
     * @param LiveStream $postBody
     * @param array $optParams Optional parameters.
     * @return LiveStream
     */
    public function update($part, LiveStream $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('update', array($params));
      if ($this->useObjects()) {
        return new LiveStream($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "playlistItems" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $playlistItems = $youtubeService->playlistItems;
   *  </code>
   */
  class PlaylistItemsServiceResource extends ServiceResource {

    /**
     * Deletes a playlist item. (playlistItems.delete)
     *
     * @param string $id The id parameter specifies the YouTube playlist item ID for the playlist item that is being deleted. In a playlistItem resource, the id property specifies the playlist item's ID.
     * @param array $optParams Optional parameters.
     */
    public function delete($id, $optParams = array()) {
      $params = array('id' => $id);
      $params = array_merge($params, $optParams);
      $data = $this->__call('delete', array($params));
      return $data;
    }
    /**
     * Adds a resource to a playlist. (playlistItems.insert)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part names that you can include in the parameter value are snippet and contentDetails.
     * @param PlaylistItem $postBody
     * @param array $optParams Optional parameters.
     * @return PlaylistItem
     */
    public function insert($part, PlaylistItem $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('insert', array($params));
      if ($this->useObjects()) {
        return new PlaylistItem($data);
      } else {
        return $data;
      }
    }
    /**
     * Returns a collection of playlist items that match the API request parameters. You can retrieve
     * all of the playlist items in a specified playlist or retrieve one or more playlist items by their
     * unique IDs. (playlistItems.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more playlistItem resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, and contentDetails.
    If the parameter identifies a property that contains child properties, the child properties will be included in the response. For example, in a playlistItem resource, the snippet property contains numerous fields, including the title, description, position, and resourceId properties. As such, if you set part=snippet, the API response will contain all of those properties.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string id The id parameter specifies a comma-separated list of one or more unique playlist item IDs.
     * @opt_param string maxResults USE_DESCRIPTION --- channels:list:maxResults
     * @opt_param string pageToken USE_DESCRIPTION --- channels:list:pageToken
     * @opt_param string playlistId The playlistId parameter specifies the unique ID of the playlist for which you want to retrieve playlist items. Note that even though this is an optional parameter, every request to retrieve playlist items must specify a value for either the id parameter or the playlistId parameter.
     * @opt_param string videoId The videoId parameter specifies that the request should return only the playlist items that contain the specified video.
     * @return PlaylistItemListResponse
     */
    public function listPlaylistItems($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new PlaylistItemListResponse($data);
      } else {
        return $data;
      }
    }
    /**
     * Modifies a playlist item. For example, you could update the item's position in the playlist.
     * (playlistItems.update)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part names that you can include in the parameter value are snippet and contentDetails.
    Note that this method will override the existing values for all of the mutable properties that are contained in any parts that the parameter value specifies. For example, a playlist item can specify a start time and end time, which identify the times portion of the video that should play when users watch the video in the playlist. If your request is updating a playlist item that sets these values, and the request's part parameter value includes the contentDetails part, the playlist item's start and end times will be updated to whatever value the request body specifies. If the request body does not specify values, the existing start and end times will be removed and replaced with the default settings.
     * @param PlaylistItem $postBody
     * @param array $optParams Optional parameters.
     * @return PlaylistItem
     */
    public function update($part, PlaylistItem $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('update', array($params));
      if ($this->useObjects()) {
        return new PlaylistItem($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "playlists" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $playlists = $youtubeService->playlists;
   *  </code>
   */
  class PlaylistsServiceResource extends ServiceResource {

    /**
     * Deletes a playlist. (playlists.delete)
     *
     * @param string $id The id parameter specifies the YouTube playlist ID for the playlist that is being deleted. In a playlist resource, the id property specifies the playlist's ID.
     * @param array $optParams Optional parameters.
     */
    public function delete($id, $optParams = array()) {
      $params = array('id' => $id);
      $params = array_merge($params, $optParams);
      $data = $this->__call('delete', array($params));
      return $data;
    }
    /**
     * Creates a playlist. (playlists.insert)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part names that you can include in the parameter value are snippet and status.
     * @param Playlist $postBody
     * @param array $optParams Optional parameters.
     * @return Playlist
     */
    public function insert($part, Playlist $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('insert', array($params));
      if ($this->useObjects()) {
        return new Playlist($data);
      } else {
        return $data;
      }
    }
    /**
     * Returns a collection of playlists that match the API request parameters. For example, you can
     * retrieve all playlists that the authenticated user owns, or you can retrieve one or more
     * playlists by their unique IDs. (playlists.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more playlist resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, and status.
    If the parameter identifies a property that contains child properties, the child properties will be included in the response. For example, in a playlist resource, the snippet property contains properties like author, title, description, tags, and timeCreated. As such, if you set part=snippet, the API response will contain all of those properties.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string channelId This value indicates that the API should only return the specified channel's playlists.
     * @opt_param string id The id parameter specifies a comma-separated list of the YouTube playlist ID(s) for the resource(s) that are being retrieved. In a playlist resource, the id property specifies the playlist's YouTube playlist ID.
     * @opt_param string maxResults USE_DESCRIPTION --- channels:list:maxResults
     * @opt_param bool mine Set this parameter's value to true to instruct the API to only return playlists owned by the authenticated user.
     * @opt_param string pageToken USE_DESCRIPTION --- channels:list:pageToken
     * @return PlaylistListResponse
     */
    public function listPlaylists($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new PlaylistListResponse($data);
      } else {
        return $data;
      }
    }
    /**
     * Modifies a playlist. For example, you could change a playlist's title, description, or privacy
     * status. (playlists.update)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part names that you can include in the parameter value are snippet and status.
    Note that this method will override the existing values for all of the mutable properties that are contained in any parts that the parameter value specifies. For example, a playlist's privacy setting is contained in the status part. As such, if your request is updating a private playlist, and the request's part parameter value includes the status part, the playlist's privacy setting will be updated to whatever value the request body specifies. If the request body does not specify a value, the existing privacy setting will be removed and the playlist will revert to the default privacy setting.
     * @param Playlist $postBody
     * @param array $optParams Optional parameters.
     * @return Playlist
     */
    public function update($part, Playlist $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('update', array($params));
      if ($this->useObjects()) {
        return new Playlist($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "search" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $search = $youtubeService->search;
   *  </code>
   */
  class SearchServiceResource extends ServiceResource {

    /**
     * Returns a collection of search results that match the query parameters specified in the API
     * request. By default, a search result set identifies matching video, channel, and playlist
     * resources, but you can also configure queries to only retrieve a specific type of resource.
     * (search.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more search resource properties that the API response will include. The part names that you can include in the parameter value are id and snippet.
    If the parameter identifies a property that contains child properties, the child properties will be included in the response. For example, in a search result, the snippet property contains other properties that identify the result's title, description, and so forth. If you set part=snippet, the API response will also contain all of those nested properties.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string channelId The channelId parameter indicates that the API response should only contain resources created by the channel
     * @opt_param string channelType The channelType parameter lets you restrict a search to a particular type of channel.
     * @opt_param bool forContentOwner The forContentOwner parameter restricts the search to only retrieve resources owned by the content owner specified by the onBehalfOfContentOwner parameter. The user must be authenticated as a CMS account linked to the specified content owner and onBehalfOfContentOwner must be provided.
     * @opt_param bool forMine The forMine parameter restricts the search to only retrieve videos owned by the authenticated user.
     * @opt_param string maxResults USE_DESCRIPTION --- channels:list:maxResults
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @opt_param string order The order parameter specifies the method that will be used to order resources in the API response.
     * @opt_param string pageToken USE_DESCRIPTION --- channels:list:pageToken
     * @opt_param string publishedAfter The publishedAfter parameter indicates that the API response should only contain resources created after the specified time. The value is an RFC 3339 formatted date-time value (1970-01-01T00:00:00Z).
     * @opt_param string publishedBefore The publishedBefore parameter indicates that the API response should only contain resources created before the specified time. The value is an RFC 3339 formatted date-time value (1970-01-01T00:00:00Z).
     * @opt_param string q The q parameter specifies the query term to search for.
     * @opt_param string regionCode The regionCode parameter instructs the API to return search results for the specified country. The parameter value is an ISO 3166-1 alpha-2 country code.
     * @opt_param string relatedToVideoId The relatedToVideoId parameter retrieves a list of videos that are related to the video that the parameter value identifies. The parameter value must be set to a YouTube video ID and, if you are using this parameter, the type parameter must be set to video.
     * @opt_param string safeSearch The safeSearch parameter indicates whether the search results should include restricted content as well as standard content.
     * @opt_param string topicId The topicId parameter indicates that the API response should only contain resources associated with the specified topic. The value identifies a Freebase topic ID.
     * @opt_param string type The type parameter restricts a search query to only retrieve a particular type of resource.
     * @opt_param string videoCaption The videoCaption parameter indicates whether the API should filter video search results based on whether they have captions.
     * @opt_param string videoCategoryId The videoCategoryId parameter filters video search results based on their category.
     * @opt_param string videoDefinition The videoDefinition parameter lets you restrict a search to only include either high definition (HD) or standard definition (SD) videos. HD videos are available for playback in at least 720p, though higher resolutions, like 1080p, might also be available.
     * @opt_param string videoDimension The videoDimension parameter lets you restrict a search to only retrieve 2D or 3D videos.
     * @opt_param string videoDuration The videoDuration parameter filters video search results based on their duration.
     * @opt_param string videoEmbeddable The videoEmbeddable parameter lets you to restrict a search to only videos that can be embedded into a webpage.
     * @opt_param string videoLicense The videoLicense parameter filters search results to only include videos with a particular license. YouTube lets video uploaders choose to attach either the Creative Commons license or the standard YouTube license to each of their videos.
     * @opt_param string videoSyndicated The videoSyndicated parameter lets you to restrict a search to only videos that can be played outside youtube.com.
     * @opt_param string videoType The videoType parameter lets you restrict a search to a particular type of videos.
     * @return SearchListResponse
     */
    public function listSearch($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new SearchListResponse($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "subscriptions" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $subscriptions = $youtubeService->subscriptions;
   *  </code>
   */
  class SubscriptionsServiceResource extends ServiceResource {

    /**
     * Deletes a subscription. (subscriptions.delete)
     *
     * @param string $id The id parameter specifies the YouTube subscription ID for the resource that is being deleted. In a subscription resource, the id property specifies the YouTube subscription ID.
     * @param array $optParams Optional parameters.
     */
    public function delete($id, $optParams = array()) {
      $params = array('id' => $id);
      $params = array_merge($params, $optParams);
      $data = $this->__call('delete', array($params));
      return $data;
    }
    /**
     * Adds a subscription for the authenticated user's channel. (subscriptions.insert)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part names that you can include in the parameter value are snippet and contentDetails.
     * @param Subscription $postBody
     * @param array $optParams Optional parameters.
     * @return Subscription
     */
    public function insert($part, Subscription $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('insert', array($params));
      if ($this->useObjects()) {
        return new Subscription($data);
      } else {
        return $data;
      }
    }
    /**
     * Returns subscription resources that match the API request criteria. (subscriptions.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more subscription resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, and contentDetails.
    If the parameter identifies a property that contains child properties, the child properties will be included in the response. For example, in a subscription resource, the snippet property contains other properties, such as a display title for the subscription. If you set part=snippet, the API response will also contain all of those nested properties.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string channelId The channelId parameter specifies a YouTube channel ID. The API will only return that channel's subscriptions.
     * @opt_param string forChannelId The forChannelId parameter specifies a comma-separated list of channel IDs. The API response will then only contain subscriptions matching those channels.
     * @opt_param string id The id parameter specifies a comma-separated list of the YouTube subscription ID(s) for the resource(s) that are being retrieved. In a subscription resource, the id property specifies the YouTube subscription ID.
     * @opt_param string maxResults USE_DESCRIPTION --- channels:list:maxResults
     * @opt_param bool mine Set this parameter's value to true to retrieve a feed of the authenticated user's subscriptions.
     * @opt_param bool mySubscribers Set this parameter's value to true to retrieve a feed of the subscribers of the authenticated user.
     * @opt_param string order The order parameter specifies the method that will be used to sort resources in the API response.
     * @opt_param string pageToken USE_DESCRIPTION --- channels:list:pageToken
     * @return SubscriptionListResponse
     */
    public function listSubscriptions($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new SubscriptionListResponse($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "thumbnails" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $thumbnails = $youtubeService->thumbnails;
   *  </code>
   */
  class ThumbnailsServiceResource extends ServiceResource {

    /**
     * Uploads a custom video thumbnail to YouTube and sets it for a video. (thumbnails.set)
     *
     * @param string $videoId The videoId parameter specifies a YouTube video ID for which the custom video thumbnail is being provided.
     * @param array $optParams Optional parameters.
     * @return ThumbnailListResponse
     */
    public function set($videoId, $optParams = array()) {
      $params = array('videoId' => $videoId);
      $params = array_merge($params, $optParams);
      $data = $this->__call('set', array($params));
      if ($this->useObjects()) {
        return new ThumbnailListResponse($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "videoCategories" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $videoCategories = $youtubeService->videoCategories;
   *  </code>
   */
  class VideoCategoriesServiceResource extends ServiceResource {

    /**
     * Returns a list of categories that can be associated with YouTube videos. (videoCategories.list)
     *
     * @param string $part The part parameter specifies the videoCategory resource parts that the API response will include. Supported values are id and snippet.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string hl The hl parameter specifies the language that should be used for text values in the API response.
     * @opt_param string id The id parameter specifies a comma-separated list of video category IDs for the resources that you are retrieving.
     * @opt_param string regionCode The regionCode parameter instructs the API to return the list of video categories available in the specified country. The parameter value is an ISO 3166-1 alpha-2 country code.
     * @return VideoCategoryListResponse
     */
    public function listVideoCategories($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new VideoCategoryListResponse($data);
      } else {
        return $data;
      }
    }
  }

  /**
   * The "videos" collection of methods.
   * Typical usage is:
   *  <code>
   *   $youtubeService = new YouTubeService(...);
   *   $videos = $youtubeService->videos;
   *  </code>
   */
  class VideosServiceResource extends ServiceResource {

    /**
     * Deletes a YouTube video. (videos.delete)
     *
     * @param string $id The id parameter specifies the YouTube video ID for the resource that is being deleted. In a video resource, the id property specifies the video's ID.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     */
    public function delete($id, $optParams = array()) {
      $params = array('id' => $id);
      $params = array_merge($params, $optParams);
      $data = $this->__call('delete', array($params));
      return $data;
    }
    /**
     * Get user ratings for videos. (videos.getRating)
     *
     * @param string $id The id parameter specifies a comma-separated list of the YouTube video ID(s) for the resource(s) that are being retrieved. In a video resource, the id property specifies the video's ID.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @return VideoGetRatingResponse
     */
    public function getRating($id, $optParams = array()) {
      $params = array('id' => $id);
      $params = array_merge($params, $optParams);
      $data = $this->__call('getRating', array($params));
      if ($this->useObjects()) {
        return new VideoGetRatingResponse($data);
      } else {
        return $data;
      }
    }
    /**
     * Uploads a video to YouTube and optionally sets the video's metadata. (videos.insert)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part names that you can include in the parameter value are snippet, contentDetails, player, statistics, status, and topicDetails. However, not all of those parts contain properties that can be set when setting or updating a video's metadata. For example, the statistics object encapsulates statistics that YouTube calculates for a video and does not contain values that you can set or modify. If the parameter value specifies a part that does not contain mutable values, that part will still be included in the API response.
     * @param Video $postBody
     * @param array $optParams Optional parameters.
     *
     * @opt_param bool autoLevels The autoLevels parameter specifies whether the video should be auto-leveled by YouTube.
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @opt_param string onBehalfOfContentOwnerChannel This parameter can only be used in a properly authorized request. Note: This parameter is intended exclusively for YouTube content partners.
    The onBehalfOfContentOwnerChannel parameter indicates that the request's authorization credentials identify a YouTube CMS user who is acting on behalf of the channel specified in the parameter value. This parameter must be used in conjunction with the onBehalfOfContentOwner parameter, and the user must be authenticated using a CMS account that is linked to the content owner that the onBehalfOfContentOwner parameter specifies. In addition, the channel that the onBehalfOfContentOwnerChannel parameter value specifies must be linked to the content owner that the onBehalfOfContentOwner parameter specifies.
    This parameter is intended for YouTube content partners that own and manage many different YouTube channels. It allows content owners to authenticate once and perform actions on behalf of the channel specified in the parameter value, without having to provide authentication credentials for each separate channel.
     * @opt_param bool stabilize The stabilize parameter specifies whether the video should be stabilized by YouTube.
     * @return Video
     */
    public function insert($part, Video $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('insert', array($params));
      if ($this->useObjects()) {
        return new Video($data);
      } else {
        return $data;
      }
    }
    /**
     * Returns a list of videos that match the API request parameters. (videos.list)
     *
     * @param string $part The part parameter specifies a comma-separated list of one or more video resource properties that the API response will include. The part names that you can include in the parameter value are id, snippet, contentDetails, player, statistics, status, and topicDetails.
    If the parameter identifies a property that contains child properties, the child properties will be included in the response. For example, in a video resource, the snippet property contains the channelId, title, description, tags, and categoryId properties. As such, if you set part=snippet, the API response will contain all of those properties.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string chart Set this parameter's value to mostPopular to instruct the API to return videos belonging to the chart of most popular videos.
     * @opt_param string id The id parameter specifies a comma-separated list of the YouTube video ID(s) for the resource(s) that are being retrieved. In a video resource, the id property specifies the video's ID.
     * @opt_param string locale The locale parameter selects a video chart available in the specified locale. If using this parameter, chart must also be set. The parameter value is an BCP 47 locale. Supported locales include ar_AE, ar_DZ, ar_EG, ar_JO, ar_MA, ar_SA, ar_TN, ar_YE, cs_CZ, de_DE, el_GR, en_AU, en_BE, en_CA, en_GB, en_GH, en_IE, en_IL, en_IN, en_KE, en_NG, en_NZ, en_SG, en_UG, en_US, en_ZA, es_AR, es_CL, es_CO, es_ES, es_MX, es_PE, fil_PH, fr_FR, hu_HU, id_ID, it_IT, ja_JP, ko_KR, ms_MY, nl_NL, pl_PL, pt_BR, ru_RU, sv_SE, tr_TR, zh_HK, zh_TW
     * @opt_param string maxResults USE_DESCRIPTION --- channels:list:maxResults
     * @opt_param string myRating Set this parameter's value to like or dislike to instruct the API to only return videos liked or disliked by the authenticated user.
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @opt_param string pageToken USE_DESCRIPTION --- channels:list:pageToken
     * @opt_param string videoCategoryId The videoCategoryId parameter selects a video chart based on the category. If using this parameter, chart must also be set.
     * @return VideoListResponse
     */
    public function listVideos($part, $optParams = array()) {
      $params = array('part' => $part);
      $params = array_merge($params, $optParams);
      $data = $this->__call('list', array($params));
      if ($this->useObjects()) {
        return new VideoListResponse($data);
      } else {
        return $data;
      }
    }
    /**
     * Like, dislike, or remove rating from a video. (videos.rate)
     *
     * @param string $id The id parameter specifies the YouTube video ID.
     * @param string $rating Specifies the rating to record.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     */
    public function rate($id, $rating, $optParams = array()) {
      $params = array('id' => $id, 'rating' => $rating);
      $params = array_merge($params, $optParams);
      $data = $this->__call('rate', array($params));
      return $data;
    }
    /**
     * Updates a video's metadata. (videos.update)
     *
     * @param string $part The part parameter serves two purposes in this operation. It identifies the properties that the write operation will set as well as the properties that the API response will include.
    The part names that you can include in the parameter value are snippet, contentDetails, player, statistics, status, and topicDetails.
    Note that this method will override the existing values for all of the mutable properties that are contained in any parts that the parameter value specifies. For example, a video's privacy setting is contained in the status part. As such, if your request is updating a private video, and the request's part parameter value includes the status part, the video's privacy setting will be updated to whatever value the request body specifies. If the request body does not specify a value, the existing privacy setting will be removed and the video will revert to the default privacy setting.
    In addition, not all of those parts contain properties that can be set when setting or updating a video's metadata. For example, the statistics object encapsulates statistics that YouTube calculates for a video and does not contain values that you can set or modify. If the parameter value specifies a part that does not contain mutable values, that part will still be included in the API response.
     * @param Video $postBody
     * @param array $optParams Optional parameters.
     *
     * @opt_param string onBehalfOfContentOwner USE_DESCRIPTION --- channels:list:onBehalfOfContentOwner
     * @return Video
     */
    public function update($part, Video $postBody, $optParams = array()) {
      $params = array('part' => $part, 'postBody' => $postBody);
      $params = array_merge($params, $optParams);
      $data = $this->__call('update', array($params));
      if ($this->useObjects()) {
        return new Video($data);
      } else {
        return $data;
      }
    }
  }

/**
 * Service definition for YouTube (v3).
 *
 * <p>
 * Programmatic access to YouTube features.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://developers.google.com/youtube/v3" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class apiYouTubeService extends Service {
  public $activities;
  public $channelBanners;
  public $channels;
  public $guideCategories;
  public $liveBroadcasts;
  public $liveStreams;
  public $playlistItems;
  public $playlists;
  public $search;
  public $subscriptions;
  public $thumbnails;
  public $videoCategories;
  public $videos;
  /**
   * Constructs the internal representation of the YouTube service.
   *
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->servicePath = '/youtube/v3/';
    $this->restBasePath = '/youtube/v3/';
    $this->version = 'v3';
    $this->serviceName = 'youtube';
    $client->addService($this->serviceName, $this->version);
    $this->activities = new ActivitiesServiceResource($this, $this->serviceName, 'activities', json_decode('{"methods": {"insert": {"id": "youtube.activities.insert", "path": "activities", "httpMethod": "POST", "parameters": {"part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "Activity"}, "response": {"$ref": "Activity"}, "scopes": ["www.googleapis.comcom/auth/youtube"]}, "list": {"id": "youtube.activities.list", "path": "activities", "httpMethod": "GET", "parameters": {"channelId": {"type": "string", "location": "query"}, "home": {"type": "boolean", "location": "query"}, "maxResults": {"type": "integer", "default": "5", "format": "uint32", "minimum": "0", "maximum": "50", "location": "query"}, "mine": {"type": "boolean", "location": "query"}, "pageToken": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}, "publishedAfter": {"type": "string", "format": "date-time", "location": "query"}, "publishedBefore": {"type": "string", "format": "date-time", "location": "query"}, "regionCode": {"type": "string", "location": "query"}}, "response": {"$ref": "ActivityListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly"]}}}', true));
    $this->channelBanners = new ChannelBannersServiceResource($this, $this->serviceName, 'channelBanners', json_decode('{"methods": {"insert": {"id": "youtube.channelBanners.insert", "path": "channelBanners/insert", "httpMethod": "POST", "parameters": {"onBehalfOfContentOwner": {"type": "string", "location": "query"}}, "request": {"$ref": "ChannelBannerResource"}, "response": {"$ref": "ChannelBannerResource"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.upload"], "supportsMediaUpload": true, "mediaUpload": {"accept": ["application/octet-stream", "image/jpeg", "image/png"], "maxSize": "6MB", "protocols": {"simple": {"multipart": true, "path": "/upload/youtube/v3/channelBanners/insert"}, "resumable": {"multipart": true, "path": "/resumable/upload/youtube/v3/channelBanners/insert"}}}}}}', true));
    $this->channels = new ChannelsServiceResource($this, $this->serviceName, 'channels', json_decode('{"methods": {"list": {"id": "youtube.channels.list", "path": "channels", "httpMethod": "GET", "parameters": {"categoryId": {"type": "string", "location": "query"}, "forUsername": {"type": "string", "location": "query"}, "id": {"type": "string", "location": "query"}, "managedByMe": {"type": "boolean", "location": "query"}, "maxResults": {"type": "integer", "default": "5", "format": "uint32", "minimum": "0", "maximum": "50", "location": "query"}, "mine": {"type": "boolean", "location": "query"}, "mySubscribers": {"type": "boolean", "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}, "pageToken": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "response": {"$ref": "ChannelListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly", "www.googleapis.comcom/auth/youtubepartner"]}, "update": {"id": "youtube.channels.update", "path": "channels", "httpMethod": "PUT", "parameters": {"onBehalfOfContentOwner": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "Channel"}, "response": {"$ref": "Channel"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}}}', true));
    $this->guideCategories = new GuideCategoriesServiceResource($this, $this->serviceName, 'guideCategories', json_decode('{"methods": {"list": {"id": "youtube.guideCategories.list", "path": "guideCategories", "httpMethod": "GET", "parameters": {"hl": {"type": "string", "default": "en-US", "location": "query"}, "id": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}, "regionCode": {"type": "string", "location": "query"}}, "response": {"$ref": "GuideCategoryListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly", "www.googleapis.comcom/auth/youtubepartner"]}}}', true));
    $this->liveBroadcasts = new LiveBroadcastsServiceResource($this, $this->serviceName, 'liveBroadcasts', json_decode('{"methods": {"bind": {"id": "youtube.liveBroadcasts.bind", "path": "liveBroadcasts/bind", "httpMethod": "POST", "parameters": {"id": {"type": "string", "required": true, "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}, "streamId": {"type": "string", "location": "query"}}, "response": {"$ref": "LiveBroadcast"}, "scopes": ["www.googleapis.comcom/auth/youtube"]}, "control": {"id": "youtube.liveBroadcasts.control", "path": "liveBroadcasts/control", "httpMethod": "POST", "parameters": {"displaySlate": {"type": "boolean", "location": "query"}, "id": {"type": "string", "required": true, "location": "query"}, "offsetTimeMs": {"type": "string", "format": "uint64", "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "response": {"$ref": "LiveBroadcast"}, "scopes": ["www.googleapis.comcom/auth/youtube"]}, "delete": {"id": "youtube.liveBroadcasts.delete", "path": "liveBroadcasts", "httpMethod": "DELETE", "parameters": {"id": {"type": "string", "required": true, "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}}, "scopes": ["www.googleapis.comcom/auth/youtube"]}, "insert": {"id": "youtube.liveBroadcasts.insert", "path": "liveBroadcasts", "httpMethod": "POST", "parameters": {"onBehalfOfContentOwner": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "LiveBroadcast"}, "response": {"$ref": "LiveBroadcast"}, "scopes": ["www.googleapis.comcom/auth/youtube"]}, "list": {"id": "youtube.liveBroadcasts.list", "path": "liveBroadcasts", "httpMethod": "GET", "parameters": {"broadcastStatus": {"type": "string", "enum": ["active", "all", "completed", "upcoming"], "location": "query"}, "id": {"type": "string", "location": "query"}, "maxResults": {"type": "integer", "default": "5", "format": "uint32", "minimum": "0", "maximum": "50", "location": "query"}, "mine": {"type": "boolean", "location": "query"}, "pageToken": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "response": {"$ref": "LiveBroadcastList"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly"]}, "transition": {"id": "youtube.liveBroadcasts.transition", "path": "liveBroadcasts/transition", "httpMethod": "POST", "parameters": {"broadcastStatus": {"type": "string", "required": true, "enum": ["complete", "live", "testing"], "location": "query"}, "id": {"type": "string", "required": true, "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "response": {"$ref": "LiveBroadcast"}, "scopes": ["www.googleapis.comcom/auth/youtube"]}, "update": {"id": "youtube.liveBroadcasts.update", "path": "liveBroadcasts", "httpMethod": "PUT", "parameters": {"onBehalfOfContentOwner": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "LiveBroadcast"}, "response": {"$ref": "LiveBroadcast"}, "scopes": ["www.googleapis.comcom/auth/youtube"]}}}', true));
    $this->liveStreams = new LiveStreamsServiceResource($this, $this->serviceName, 'liveStreams', json_decode('{"methods": {"delete": {"id": "youtube.liveStreams.delete", "path": "liveStreams", "httpMethod": "DELETE", "parameters": {"id": {"type": "string", "required": true, "location": "query"}}, "scopes": ["www.googleapis.comcom/auth/youtube"]}, "insert": {"id": "youtube.liveStreams.insert", "path": "liveStreams", "httpMethod": "POST", "parameters": {"part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "LiveStream"}, "response": {"$ref": "LiveStream"}, "scopes": ["www.googleapis.comcom/auth/youtube"]}, "list": {"id": "youtube.liveStreams.list", "path": "liveStreams", "httpMethod": "GET", "parameters": {"id": {"type": "string", "location": "query"}, "maxResults": {"type": "integer", "default": "5", "format": "uint32", "minimum": "0", "maximum": "50", "location": "query"}, "mine": {"type": "boolean", "location": "query"}, "pageToken": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "response": {"$ref": "LiveStreamList"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly"]}, "update": {"id": "youtube.liveStreams.update", "path": "liveStreams", "httpMethod": "PUT", "parameters": {"part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "LiveStream"}, "response": {"$ref": "LiveStream"}, "scopes": ["www.googleapis.comcom/auth/youtube"]}}}', true));
    $this->playlistItems = new PlaylistItemsServiceResource($this, $this->serviceName, 'playlistItems', json_decode('{"methods": {"delete": {"id": "youtube.playlistItems.delete", "path": "playlistItems", "httpMethod": "DELETE", "parameters": {"id": {"type": "string", "required": true, "location": "query"}}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}, "insert": {"id": "youtube.playlistItems.insert", "path": "playlistItems", "httpMethod": "POST", "parameters": {"part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "PlaylistItem"}, "response": {"$ref": "PlaylistItem"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}, "list": {"id": "youtube.playlistItems.list", "path": "playlistItems", "httpMethod": "GET", "parameters": {"id": {"type": "string", "location": "query"}, "maxResults": {"type": "integer", "default": "5", "format": "uint32", "minimum": "0", "maximum": "50", "location": "query"}, "pageToken": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}, "playlistId": {"type": "string", "location": "query"}, "videoId": {"type": "string", "location": "query"}}, "response": {"$ref": "PlaylistItemListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly", "www.googleapis.comcom/auth/youtubepartner"], "supportsSubscription": true}, "update": {"id": "youtube.playlistItems.update", "path": "playlistItems", "httpMethod": "PUT", "parameters": {"part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "PlaylistItem"}, "response": {"$ref": "PlaylistItem"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}}}', true));
    $this->playlists = new PlaylistsServiceResource($this, $this->serviceName, 'playlists', json_decode('{"methods": {"delete": {"id": "youtube.playlists.delete", "path": "playlists", "httpMethod": "DELETE", "parameters": {"id": {"type": "string", "required": true, "location": "query"}}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}, "insert": {"id": "youtube.playlists.insert", "path": "playlists", "httpMethod": "POST", "parameters": {"part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "Playlist"}, "response": {"$ref": "Playlist"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}, "list": {"id": "youtube.playlists.list", "path": "playlists", "httpMethod": "GET", "parameters": {"channelId": {"type": "string", "location": "query"}, "id": {"type": "string", "location": "query"}, "maxResults": {"type": "integer", "default": "5", "format": "uint32", "minimum": "0", "maximum": "50", "location": "query"}, "mine": {"type": "boolean", "location": "query"}, "pageToken": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "response": {"$ref": "PlaylistListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly", "www.googleapis.comcom/auth/youtubepartner"]}, "update": {"id": "youtube.playlists.update", "path": "playlists", "httpMethod": "PUT", "parameters": {"part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "Playlist"}, "response": {"$ref": "Playlist"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}}}', true));
    $this->search = new SearchServiceResource($this, $this->serviceName, 'search', json_decode('{"methods": {"list": {"id": "youtube.search.list", "path": "search", "httpMethod": "GET", "parameters": {"channelId": {"type": "string", "location": "query"}, "channelType": {"type": "string", "enum": ["any", "show"], "location": "query"}, "forContentOwner": {"type": "boolean", "location": "query"}, "forMine": {"type": "boolean", "location": "query"}, "maxResults": {"type": "integer", "default": "5", "format": "uint32", "minimum": "0", "maximum": "50", "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}, "order": {"type": "string", "default": "SEARCH_SORT_RELEVANCE", "enum": ["date", "rating", "relevance", "title", "videoCount", "viewCount"], "location": "query"}, "pageToken": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}, "publishedAfter": {"type": "string", "format": "date-time", "location": "query"}, "publishedBefore": {"type": "string", "format": "date-time", "location": "query"}, "q": {"type": "string", "location": "query"}, "regionCode": {"type": "string", "location": "query"}, "relatedToVideoId": {"type": "string", "location": "query"}, "safeSearch": {"type": "string", "enum": ["moderate", "none", "strict"], "location": "query"}, "topicId": {"type": "string", "location": "query"}, "type": {"type": "string", "default": "video,channel,playlist", "location": "query"}, "videoCaption": {"type": "string", "enum": ["any", "closedCaption", "none"], "location": "query"}, "videoCategoryId": {"type": "string", "location": "query"}, "videoDefinition": {"type": "string", "enum": ["any", "high", "standard"], "location": "query"}, "videoDimension": {"type": "string", "enum": ["2d", "3d", "any"], "location": "query"}, "videoDuration": {"type": "string", "enum": ["any", "long", "medium", "short"], "location": "query"}, "videoEmbeddable": {"type": "string", "enum": ["any", "true"], "location": "query"}, "videoLicense": {"type": "string", "enum": ["any", "creativeCommon", "youtube"], "location": "query"}, "videoSyndicated": {"type": "string", "enum": ["any", "true"], "location": "query"}, "videoType": {"type": "string", "enum": ["any", "episode", "movie"], "location": "query"}}, "response": {"$ref": "SearchListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly", "www.googleapis.comcom/auth/youtubepartner"]}}}', true));
    $this->subscriptions = new SubscriptionsServiceResource($this, $this->serviceName, 'subscriptions', json_decode('{"methods": {"delete": {"id": "youtube.subscriptions.delete", "path": "subscriptions", "httpMethod": "DELETE", "parameters": {"id": {"type": "string", "required": true, "location": "query"}}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}, "insert": {"id": "youtube.subscriptions.insert", "path": "subscriptions", "httpMethod": "POST", "parameters": {"part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "Subscription"}, "response": {"$ref": "Subscription"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}, "list": {"id": "youtube.subscriptions.list", "path": "subscriptions", "httpMethod": "GET", "parameters": {"channelId": {"type": "string", "location": "query"}, "forChannelId": {"type": "string", "location": "query"}, "id": {"type": "string", "location": "query"}, "maxResults": {"type": "integer", "default": "5", "format": "uint32", "minimum": "0", "maximum": "50", "location": "query"}, "mine": {"type": "boolean", "location": "query"}, "mySubscribers": {"type": "boolean", "location": "query"}, "order": {"type": "string", "default": "SUBSCRIPTION_ORDER_RELEVANCE", "enum": ["alphabetical", "relevance", "unread"], "location": "query"}, "pageToken": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "response": {"$ref": "SubscriptionListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly", "www.googleapis.comcom/auth/youtubepartner"]}}}', true));
    $this->thumbnails = new ThumbnailsServiceResource($this, $this->serviceName, 'thumbnails', json_decode('{"methods": {"set": {"id": "youtube.thumbnails.set", "path": "thumbnails/set", "httpMethod": "POST", "parameters": {"videoId": {"type": "string", "required": true, "location": "query"}}, "response": {"$ref": "ThumbnailListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.upload", "www.googleapis.comcom/auth/youtubepartner"], "supportsMediaUpload": true, "mediaUpload": {"accept": ["application/octet-stream", "image/jpeg", "image/png"], "maxSize": "2MB", "protocols": {"simple": {"multipart": true, "path": "/upload/youtube/v3/thumbnails/set"}, "resumable": {"multipart": true, "path": "/resumable/upload/youtube/v3/thumbnails/set"}}}}}}', true));
    $this->videoCategories = new VideoCategoriesServiceResource($this, $this->serviceName, 'videoCategories', json_decode('{"methods": {"list": {"id": "youtube.videoCategories.list", "path": "videoCategories", "httpMethod": "GET", "parameters": {"hl": {"type": "string", "default": "en_US", "location": "query"}, "id": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}, "regionCode": {"type": "string", "location": "query"}}, "response": {"$ref": "VideoCategoryListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly", "www.googleapis.comcom/auth/youtubepartner"]}}}', true));
    $this->videos = new VideosServiceResource($this, $this->serviceName, 'videos', json_decode('{"methods": {"delete": {"id": "youtube.videos.delete", "path": "videos", "httpMethod": "DELETE", "parameters": {"id": {"type": "string", "required": true, "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}, "getRating": {"id": "youtube.videos.getRating", "path": "videos/getRating", "httpMethod": "GET", "parameters": {"id": {"type": "string", "required": true, "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}}, "response": {"$ref": "VideoGetRatingResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}, "insert": {"id": "youtube.videos.insert", "path": "videos", "httpMethod": "POST", "parameters": {"autoLevels": {"type": "boolean", "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}, "onBehalfOfContentOwnerChannel": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}, "stabilize": {"type": "boolean", "location": "query"}}, "request": {"$ref": "Video"}, "response": {"$ref": "Video"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.upload", "www.googleapis.comcom/auth/youtubepartner"], "supportsMediaUpload": true, "mediaUpload": {"accept": ["application/octet-stream", "video/*"], "maxSize": "64GB", "protocols": {"simple": {"multipart": true, "path": "/upload/youtube/v3/videos"}, "resumable": {"multipart": true, "path": "/resumable/upload/youtube/v3/videos"}}}}, "list": {"id": "youtube.videos.list", "path": "videos", "httpMethod": "GET", "parameters": {"chart": {"type": "string", "enum": ["mostPopular"], "location": "query"}, "id": {"type": "string", "location": "query"}, "locale": {"type": "string", "default": "en_US", "location": "query"}, "maxResults": {"type": "integer", "default": "5", "format": "uint32", "minimum": "1", "maximum": "50", "location": "query"}, "myRating": {"type": "string", "enum": ["dislike", "like"], "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}, "pageToken": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}, "videoCategoryId": {"type": "string", "default": "0", "location": "query"}}, "response": {"$ref": "VideoListResponse"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtube.readonly", "www.googleapis.comcom/auth/youtubepartner"]}, "rate": {"id": "youtube.videos.rate", "path": "videos/rate", "httpMethod": "POST", "parameters": {"id": {"type": "string", "required": true, "location": "query"}, "onBehalfOfContentOwner": {"type": "string", "location": "query"}, "rating": {"type": "string", "required": true, "enum": ["dislike", "like", "none"], "location": "query"}}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}, "update": {"id": "youtube.videos.update", "path": "videos", "httpMethod": "PUT", "parameters": {"onBehalfOfContentOwner": {"type": "string", "location": "query"}, "part": {"type": "string", "required": true, "location": "query"}}, "request": {"$ref": "Video"}, "response": {"$ref": "Video"}, "scopes": ["www.googleapis.comcom/auth/youtube", "www.googleapis.comcom/auth/youtubepartner"]}}}', true));

  }
}



class AccessPolicy extends Model {
  public $allowed;
  public $exception;
  public function setAllowed( $allowed) {
    $this->allowed = $allowed;
  }
  public function getAllowed() {
    return $this->allowed;
  }
  public function setException(/* array(string) */ $exception) {
    $this->assertIsArray($exception, 'string', __METHOD__);
    $this->exception = $exception;
  }
  public function getException() {
    return $this->exception;
  }
}

class Activity extends Model {
  protected $__contentDetailsType = 'ActivityContentDetails';
  protected $__contentDetailsDataType = '';
  public $contentDetails;
  public $etag;
  public $id;
  public $kind;
  protected $__snippetType = 'ActivitySnippet';
  protected $__snippetDataType = '';
  public $snippet;
  public function setContentDetails(ActivityContentDetails $contentDetails) {
    $this->contentDetails = $contentDetails;
  }
  public function getContentDetails() {
    return $this->contentDetails;
  }
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setSnippet(ActivitySnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
}

class ActivityContentDetails extends Model {
  protected $__bulletinType = 'ActivityContentDetailsBulletin';
  protected $__bulletinDataType = '';
  public $bulletin;
  protected $__channelItemType = 'ActivityContentDetailsChannelItem';
  protected $__channelItemDataType = '';
  public $channelItem;
  protected $__commentType = 'ActivityContentDetailsComment';
  protected $__commentDataType = '';
  public $comment;
  protected $__favoriteType = 'ActivityContentDetailsFavorite';
  protected $__favoriteDataType = '';
  public $favorite;
  protected $__likeType = 'ActivityContentDetailsLike';
  protected $__likeDataType = '';
  public $like;
  protected $__playlistItemType = 'ActivityContentDetailsPlaylistItem';
  protected $__playlistItemDataType = '';
  public $playlistItem;
  protected $__promotedItemType = 'ActivityContentDetailsPromotedItem';
  protected $__promotedItemDataType = '';
  public $promotedItem;
  protected $__recommendationType = 'ActivityContentDetailsRecommendation';
  protected $__recommendationDataType = '';
  public $recommendation;
  protected $__socialType = 'ActivityContentDetailsSocial';
  protected $__socialDataType = '';
  public $social;
  protected $__subscriptionType = 'ActivityContentDetailsSubscription';
  protected $__subscriptionDataType = '';
  public $subscription;
  protected $__uploadType = 'ActivityContentDetailsUpload';
  protected $__uploadDataType = '';
  public $upload;
  public function setBulletin(ActivityContentDetailsBulletin $bulletin) {
    $this->bulletin = $bulletin;
  }
  public function getBulletin() {
    return $this->bulletin;
  }
  public function setChannelItem(ActivityContentDetailsChannelItem $channelItem) {
    $this->channelItem = $channelItem;
  }
  public function getChannelItem() {
    return $this->channelItem;
  }
  public function setComment(ActivityContentDetailsComment $comment) {
    $this->comment = $comment;
  }
  public function getComment() {
    return $this->comment;
  }
  public function setFavorite(ActivityContentDetailsFavorite $favorite) {
    $this->favorite = $favorite;
  }
  public function getFavorite() {
    return $this->favorite;
  }
  public function setLike(ActivityContentDetailsLike $like) {
    $this->like = $like;
  }
  public function getLike() {
    return $this->like;
  }
  public function setPlaylistItem(ActivityContentDetailsPlaylistItem $playlistItem) {
    $this->playlistItem = $playlistItem;
  }
  public function getPlaylistItem() {
    return $this->playlistItem;
  }
  public function setPromotedItem(ActivityContentDetailsPromotedItem $promotedItem) {
    $this->promotedItem = $promotedItem;
  }
  public function getPromotedItem() {
    return $this->promotedItem;
  }
  public function setRecommendation(ActivityContentDetailsRecommendation $recommendation) {
    $this->recommendation = $recommendation;
  }
  public function getRecommendation() {
    return $this->recommendation;
  }
  public function setSocial(ActivityContentDetailsSocial $social) {
    $this->social = $social;
  }
  public function getSocial() {
    return $this->social;
  }
  public function setSubscription(ActivityContentDetailsSubscription $subscription) {
    $this->subscription = $subscription;
  }
  public function getSubscription() {
    return $this->subscription;
  }
  public function setUpload(ActivityContentDetailsUpload $upload) {
    $this->upload = $upload;
  }
  public function getUpload() {
    return $this->upload;
  }
}

class ActivityContentDetailsBulletin extends Model {
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
}

class ActivityContentDetailsChannelItem extends Model {
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
}

class ActivityContentDetailsComment extends Model {
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
}

class ActivityContentDetailsFavorite extends Model {
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
}

class ActivityContentDetailsLike extends Model {
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
}

class ActivityContentDetailsPlaylistItem extends Model {
  public $playlistId;
  public $playlistItemId;
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  public function setPlaylistId( $playlistId) {
    $this->playlistId = $playlistId;
  }
  public function getPlaylistId() {
    return $this->playlistId;
  }
  public function setPlaylistItemId( $playlistItemId) {
    $this->playlistItemId = $playlistItemId;
  }
  public function getPlaylistItemId() {
    return $this->playlistItemId;
  }
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
}

class ActivityContentDetailsPromotedItem extends Model {
  public $adTag;
  public $clickTrackingUrl;
  public $creativeViewUrl;
  public $ctaType;
  public $descriptionText;
  public $destinationUrl;
  public $videoId;
  public function setAdTag( $adTag) {
    $this->adTag = $adTag;
  }
  public function getAdTag() {
    return $this->adTag;
  }
  public function setClickTrackingUrl( $clickTrackingUrl) {
    $this->clickTrackingUrl = $clickTrackingUrl;
  }
  public function getClickTrackingUrl() {
    return $this->clickTrackingUrl;
  }
  public function setCreativeViewUrl( $creativeViewUrl) {
    $this->creativeViewUrl = $creativeViewUrl;
  }
  public function getCreativeViewUrl() {
    return $this->creativeViewUrl;
  }
  public function setCtaType( $ctaType) {
    $this->ctaType = $ctaType;
  }
  public function getCtaType() {
    return $this->ctaType;
  }
  public function setDescriptionText( $descriptionText) {
    $this->descriptionText = $descriptionText;
  }
  public function getDescriptionText() {
    return $this->descriptionText;
  }
  public function setDestinationUrl( $destinationUrl) {
    $this->destinationUrl = $destinationUrl;
  }
  public function getDestinationUrl() {
    return $this->destinationUrl;
  }
  public function setVideoId( $videoId) {
    $this->videoId = $videoId;
  }
  public function getVideoId() {
    return $this->videoId;
  }
}

class ActivityContentDetailsRecommendation extends Model {
  public $reason;
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  protected $__seedResourceIdType = 'ResourceId';
  protected $__seedResourceIdDataType = '';
  public $seedResourceId;
  public function setReason( $reason) {
    $this->reason = $reason;
  }
  public function getReason() {
    return $this->reason;
  }
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
  public function setSeedResourceId(ResourceId $seedResourceId) {
    $this->seedResourceId = $seedResourceId;
  }
  public function getSeedResourceId() {
    return $this->seedResourceId;
  }
}

class ActivityContentDetailsSocial extends Model {
  public $author;
  public $imageUrl;
  public $referenceUrl;
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  public $type;
  public function setAuthor( $author) {
    $this->author = $author;
  }
  public function getAuthor() {
    return $this->author;
  }
  public function setImageUrl( $imageUrl) {
    $this->imageUrl = $imageUrl;
  }
  public function getImageUrl() {
    return $this->imageUrl;
  }
  public function setReferenceUrl( $referenceUrl) {
    $this->referenceUrl = $referenceUrl;
  }
  public function getReferenceUrl() {
    return $this->referenceUrl;
  }
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
  public function setType( $type) {
    $this->type = $type;
  }
  public function getType() {
    return $this->type;
  }
}

class ActivityContentDetailsSubscription extends Model {
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
}

class ActivityContentDetailsUpload extends Model {
  public $videoId;
  public function setVideoId( $videoId) {
    $this->videoId = $videoId;
  }
  public function getVideoId() {
    return $this->videoId;
  }
}

class ActivityListResponse extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'Activity';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $nextPageToken;
  protected $__pageInfoType = 'PageInfo';
  protected $__pageInfoDataType = '';
  public $pageInfo;
  public $prevPageToken;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(Activity) */ $items) {
    $this->assertIsArray($items, 'Activity', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setNextPageToken( $nextPageToken) {
    $this->nextPageToken = $nextPageToken;
  }
  public function getNextPageToken() {
    return $this->nextPageToken;
  }
  public function setPageInfo(PageInfo $pageInfo) {
    $this->pageInfo = $pageInfo;
  }
  public function getPageInfo() {
    return $this->pageInfo;
  }
  public function setPrevPageToken( $prevPageToken) {
    $this->prevPageToken = $prevPageToken;
  }
  public function getPrevPageToken() {
    return $this->prevPageToken;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class ActivitySnippet extends Model {
  public $channelId;
  public $channelTitle;
  public $description;
  public $groupId;
  public $publishedAt;
  protected $__thumbnailsType = 'ThumbnailDetails';
  protected $__thumbnailsDataType = '';
  public $thumbnails;
  public $title;
  public $type;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setChannelTitle( $channelTitle) {
    $this->channelTitle = $channelTitle;
  }
  public function getChannelTitle() {
    return $this->channelTitle;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setGroupId( $groupId) {
    $this->groupId = $groupId;
  }
  public function getGroupId() {
    return $this->groupId;
  }
  public function setPublishedAt( $publishedAt) {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt() {
    return $this->publishedAt;
  }
  public function setThumbnails(ThumbnailDetails $thumbnails) {
    $this->thumbnails = $thumbnails;
  }
  public function getThumbnails() {
    return $this->thumbnails;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
  public function setType( $type) {
    $this->type = $type;
  }
  public function getType() {
    return $this->type;
  }
}

class Channel extends Model {
  protected $__brandingSettingsType = 'ChannelBrandingSettings';
  protected $__brandingSettingsDataType = '';
  public $brandingSettings;
  protected $__contentDetailsType = 'ChannelContentDetails';
  protected $__contentDetailsDataType = '';
  public $contentDetails;
  protected $__conversionPingsType = 'ChannelConversionPings';
  protected $__conversionPingsDataType = '';
  public $conversionPings;
  public $etag;
  public $id;
  protected $__invideoPromotionType = 'InvideoPromotion';
  protected $__invideoPromotionDataType = '';
  public $invideoPromotion;
  public $kind;
  protected $__snippetType = 'ChannelSnippet';
  protected $__snippetDataType = '';
  public $snippet;
  protected $__statisticsType = 'ChannelStatistics';
  protected $__statisticsDataType = '';
  public $statistics;
  protected $__statusType = 'ChannelStatus';
  protected $__statusDataType = '';
  public $status;
  protected $__topicDetailsType = 'ChannelTopicDetails';
  protected $__topicDetailsDataType = '';
  public $topicDetails;
  public function setBrandingSettings(ChannelBrandingSettings $brandingSettings) {
    $this->brandingSettings = $brandingSettings;
  }
  public function getBrandingSettings() {
    return $this->brandingSettings;
  }
  public function setContentDetails(ChannelContentDetails $contentDetails) {
    $this->contentDetails = $contentDetails;
  }
  public function getContentDetails() {
    return $this->contentDetails;
  }
  public function setConversionPings(ChannelConversionPings $conversionPings) {
    $this->conversionPings = $conversionPings;
  }
  public function getConversionPings() {
    return $this->conversionPings;
  }
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setInvideoPromotion(InvideoPromotion $invideoPromotion) {
    $this->invideoPromotion = $invideoPromotion;
  }
  public function getInvideoPromotion() {
    return $this->invideoPromotion;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setSnippet(ChannelSnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
  public function setStatistics(ChannelStatistics $statistics) {
    $this->statistics = $statistics;
  }
  public function getStatistics() {
    return $this->statistics;
  }
  public function setStatus(ChannelStatus $status) {
    $this->status = $status;
  }
  public function getStatus() {
    return $this->status;
  }
  public function setTopicDetails(ChannelTopicDetails $topicDetails) {
    $this->topicDetails = $topicDetails;
  }
  public function getTopicDetails() {
    return $this->topicDetails;
  }
}

class ChannelBannerResource extends Model {
  public $etag;
  public $kind;
  public $url;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setUrl( $url) {
    $this->url = $url;
  }
  public function getUrl() {
    return $this->url;
  }
}

class ChannelBrandingSettings extends Model {
  protected $__channelType = 'ChannelSettings';
  protected $__channelDataType = '';
  public $channel;
  protected $__hintsType = 'PropertyValue';
  protected $__hintsDataType = 'array';
  public $hints;
  protected $__imageType = 'ImageSettings';
  protected $__imageDataType = '';
  public $image;
  protected $__watchType = 'WatchSettings';
  protected $__watchDataType = '';
  public $watch;
  public function setChannel(ChannelSettings $channel) {
    $this->channel = $channel;
  }
  public function getChannel() {
    return $this->channel;
  }
  public function setHints(/* array(PropertyValue) */ $hints) {
    $this->assertIsArray($hints, 'PropertyValue', __METHOD__);
    $this->hints = $hints;
  }
  public function getHints() {
    return $this->hints;
  }
  public function setImage(ImageSettings $image) {
    $this->image = $image;
  }
  public function getImage() {
    return $this->image;
  }
  public function setWatch(WatchSettings $watch) {
    $this->watch = $watch;
  }
  public function getWatch() {
    return $this->watch;
  }
}

class ChannelContentDetails extends Model {
  public $googlePlusUserId;
  protected $__relatedPlaylistsType = 'ChannelContentDetailsRelatedPlaylists';
  protected $__relatedPlaylistsDataType = '';
  public $relatedPlaylists;
  public function setGooglePlusUserId( $googlePlusUserId) {
    $this->googlePlusUserId = $googlePlusUserId;
  }
  public function getGooglePlusUserId() {
    return $this->googlePlusUserId;
  }
  public function setRelatedPlaylists(ChannelContentDetailsRelatedPlaylists $relatedPlaylists) {
    $this->relatedPlaylists = $relatedPlaylists;
  }
  public function getRelatedPlaylists() {
    return $this->relatedPlaylists;
  }
}

class ChannelContentDetailsRelatedPlaylists extends Model {
  public $favorites;
  public $likes;
  public $uploads;
  public $watchHistory;
  public $watchLater;
  public function setFavorites( $favorites) {
    $this->favorites = $favorites;
  }
  public function getFavorites() {
    return $this->favorites;
  }
  public function setLikes( $likes) {
    $this->likes = $likes;
  }
  public function getLikes() {
    return $this->likes;
  }
  public function setUploads( $uploads) {
    $this->uploads = $uploads;
  }
  public function getUploads() {
    return $this->uploads;
  }
  public function setWatchHistory( $watchHistory) {
    $this->watchHistory = $watchHistory;
  }
  public function getWatchHistory() {
    return $this->watchHistory;
  }
  public function setWatchLater( $watchLater) {
    $this->watchLater = $watchLater;
  }
  public function getWatchLater() {
    return $this->watchLater;
  }
}

class ChannelConversionPing extends Model {
  public $context;
  public $conversionUrl;
  public function setContext( $context) {
    $this->context = $context;
  }
  public function getContext() {
    return $this->context;
  }
  public function setConversionUrl( $conversionUrl) {
    $this->conversionUrl = $conversionUrl;
  }
  public function getConversionUrl() {
    return $this->conversionUrl;
  }
}

class ChannelConversionPings extends Model {
  protected $__pingsType = 'ChannelConversionPing';
  protected $__pingsDataType = 'array';
  public $pings;
  public function setPings(/* array(ChannelConversionPing) */ $pings) {
    $this->assertIsArray($pings, 'ChannelConversionPing', __METHOD__);
    $this->pings = $pings;
  }
  public function getPings() {
    return $this->pings;
  }
}

class ChannelListResponse extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'Channel';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $nextPageToken;
  protected $__pageInfoType = 'PageInfo';
  protected $__pageInfoDataType = '';
  public $pageInfo;
  public $prevPageToken;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(Channel) */ $items) {
    $this->assertIsArray($items, 'Channel', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setNextPageToken( $nextPageToken) {
    $this->nextPageToken = $nextPageToken;
  }
  public function getNextPageToken() {
    return $this->nextPageToken;
  }
  public function setPageInfo(PageInfo $pageInfo) {
    $this->pageInfo = $pageInfo;
  }
  public function getPageInfo() {
    return $this->pageInfo;
  }
  public function setPrevPageToken( $prevPageToken) {
    $this->prevPageToken = $prevPageToken;
  }
  public function getPrevPageToken() {
    return $this->prevPageToken;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class ChannelSettings extends Model {
  public $defaultTab;
  public $description;
  public $featuredChannelsTitle;
  public $featuredChannelsUrls;
  public $keywords;
  public $moderateComments;
  public $profileColor;
  public $showBrowseView;
  public $showRelatedChannels;
  public $title;
  public $trackingAnalyticsAccountId;
  public $unsubscribedTrailer;
  public function setDefaultTab( $defaultTab) {
    $this->defaultTab = $defaultTab;
  }
  public function getDefaultTab() {
    return $this->defaultTab;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setFeaturedChannelsTitle( $featuredChannelsTitle) {
    $this->featuredChannelsTitle = $featuredChannelsTitle;
  }
  public function getFeaturedChannelsTitle() {
    return $this->featuredChannelsTitle;
  }
  public function setFeaturedChannelsUrls(/* array(string) */ $featuredChannelsUrls) {
    $this->assertIsArray($featuredChannelsUrls, 'string', __METHOD__);
    $this->featuredChannelsUrls = $featuredChannelsUrls;
  }
  public function getFeaturedChannelsUrls() {
    return $this->featuredChannelsUrls;
  }
  public function setKeywords( $keywords) {
    $this->keywords = $keywords;
  }
  public function getKeywords() {
    return $this->keywords;
  }
  public function setModerateComments( $moderateComments) {
    $this->moderateComments = $moderateComments;
  }
  public function getModerateComments() {
    return $this->moderateComments;
  }
  public function setProfileColor( $profileColor) {
    $this->profileColor = $profileColor;
  }
  public function getProfileColor() {
    return $this->profileColor;
  }
  public function setShowBrowseView( $showBrowseView) {
    $this->showBrowseView = $showBrowseView;
  }
  public function getShowBrowseView() {
    return $this->showBrowseView;
  }
  public function setShowRelatedChannels( $showRelatedChannels) {
    $this->showRelatedChannels = $showRelatedChannels;
  }
  public function getShowRelatedChannels() {
    return $this->showRelatedChannels;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
  public function setTrackingAnalyticsAccountId( $trackingAnalyticsAccountId) {
    $this->trackingAnalyticsAccountId = $trackingAnalyticsAccountId;
  }
  public function getTrackingAnalyticsAccountId() {
    return $this->trackingAnalyticsAccountId;
  }
  public function setUnsubscribedTrailer( $unsubscribedTrailer) {
    $this->unsubscribedTrailer = $unsubscribedTrailer;
  }
  public function getUnsubscribedTrailer() {
    return $this->unsubscribedTrailer;
  }
}

class ChannelSnippet extends Model {
  public $description;
  public $publishedAt;
  protected $__thumbnailsType = 'ThumbnailDetails';
  protected $__thumbnailsDataType = '';
  public $thumbnails;
  public $title;
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setPublishedAt( $publishedAt) {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt() {
    return $this->publishedAt;
  }
  public function setThumbnails(ThumbnailDetails $thumbnails) {
    $this->thumbnails = $thumbnails;
  }
  public function getThumbnails() {
    return $this->thumbnails;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class ChannelStatistics extends Model {
  public $commentCount;
  public $subscriberCount;
  public $videoCount;
  public $viewCount;
  public function setCommentCount( $commentCount) {
    $this->commentCount = $commentCount;
  }
  public function getCommentCount() {
    return $this->commentCount;
  }
  public function setSubscriberCount( $subscriberCount) {
    $this->subscriberCount = $subscriberCount;
  }
  public function getSubscriberCount() {
    return $this->subscriberCount;
  }
  public function setVideoCount( $videoCount) {
    $this->videoCount = $videoCount;
  }
  public function getVideoCount() {
    return $this->videoCount;
  }
  public function setViewCount( $viewCount) {
    $this->viewCount = $viewCount;
  }
  public function getViewCount() {
    return $this->viewCount;
  }
}

class ChannelStatus extends Model {
  public $isLinked;
  public $privacyStatus;
  public function setIsLinked( $isLinked) {
    $this->isLinked = $isLinked;
  }
  public function getIsLinked() {
    return $this->isLinked;
  }
  public function setPrivacyStatus( $privacyStatus) {
    $this->privacyStatus = $privacyStatus;
  }
  public function getPrivacyStatus() {
    return $this->privacyStatus;
  }
}

class ChannelTopicDetails extends Model {
  public $topicIds;
  public function setTopicIds(/* array(string) */ $topicIds) {
    $this->assertIsArray($topicIds, 'string', __METHOD__);
    $this->topicIds = $topicIds;
  }
  public function getTopicIds() {
    return $this->topicIds;
  }
}

class ContentRating extends Model {
  public $acbRating;
  public $bbfcRating;
  public $cbfcRating;
  public $chvrsRating;
  public $djctqRating;
  public $eirinRating;
  public $fmocRating;
  public $fskRating;
  public $icaaRating;
  public $kmrbRating;
  public $mpaaRating;
  public $oflcRating;
  public $rtcRating;
  public $russiaRating;
  public $tvpgRating;
  public $ytRating;
  public function setAcbRating( $acbRating) {
    $this->acbRating = $acbRating;
  }
  public function getAcbRating() {
    return $this->acbRating;
  }
  public function setBbfcRating( $bbfcRating) {
    $this->bbfcRating = $bbfcRating;
  }
  public function getBbfcRating() {
    return $this->bbfcRating;
  }
  public function setCbfcRating( $cbfcRating) {
    $this->cbfcRating = $cbfcRating;
  }
  public function getCbfcRating() {
    return $this->cbfcRating;
  }
  public function setChvrsRating( $chvrsRating) {
    $this->chvrsRating = $chvrsRating;
  }
  public function getChvrsRating() {
    return $this->chvrsRating;
  }
  public function setDjctqRating( $djctqRating) {
    $this->djctqRating = $djctqRating;
  }
  public function getDjctqRating() {
    return $this->djctqRating;
  }
  public function setEirinRating( $eirinRating) {
    $this->eirinRating = $eirinRating;
  }
  public function getEirinRating() {
    return $this->eirinRating;
  }
  public function setFmocRating( $fmocRating) {
    $this->fmocRating = $fmocRating;
  }
  public function getFmocRating() {
    return $this->fmocRating;
  }
  public function setFskRating( $fskRating) {
    $this->fskRating = $fskRating;
  }
  public function getFskRating() {
    return $this->fskRating;
  }
  public function setIcaaRating( $icaaRating) {
    $this->icaaRating = $icaaRating;
  }
  public function getIcaaRating() {
    return $this->icaaRating;
  }
  public function setKmrbRating( $kmrbRating) {
    $this->kmrbRating = $kmrbRating;
  }
  public function getKmrbRating() {
    return $this->kmrbRating;
  }
  public function setMpaaRating( $mpaaRating) {
    $this->mpaaRating = $mpaaRating;
  }
  public function getMpaaRating() {
    return $this->mpaaRating;
  }
  public function setOflcRating( $oflcRating) {
    $this->oflcRating = $oflcRating;
  }
  public function getOflcRating() {
    return $this->oflcRating;
  }
  public function setRtcRating( $rtcRating) {
    $this->rtcRating = $rtcRating;
  }
  public function getRtcRating() {
    return $this->rtcRating;
  }
  public function setRussiaRating( $russiaRating) {
    $this->russiaRating = $russiaRating;
  }
  public function getRussiaRating() {
    return $this->russiaRating;
  }
  public function setTvpgRating( $tvpgRating) {
    $this->tvpgRating = $tvpgRating;
  }
  public function getTvpgRating() {
    return $this->tvpgRating;
  }
  public function setYtRating( $ytRating) {
    $this->ytRating = $ytRating;
  }
  public function getYtRating() {
    return $this->ytRating;
  }
}

class GeoPoint extends Model {
  public $altitude;
  public $latitude;
  public $longitude;
  public function setAltitude( $altitude) {
    $this->altitude = $altitude;
  }
  public function getAltitude() {
    return $this->altitude;
  }
  public function setLatitude( $latitude) {
    $this->latitude = $latitude;
  }
  public function getLatitude() {
    return $this->latitude;
  }
  public function setLongitude( $longitude) {
    $this->longitude = $longitude;
  }
  public function getLongitude() {
    return $this->longitude;
  }
}

class GuideCategory extends Model {
  public $etag;
  public $id;
  public $kind;
  protected $__snippetType = 'GuideCategorySnippet';
  protected $__snippetDataType = '';
  public $snippet;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setSnippet(GuideCategorySnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
}

class GuideCategoryListResponse extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'GuideCategory';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(GuideCategory) */ $items) {
    $this->assertIsArray($items, 'GuideCategory', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class GuideCategorySnippet extends Model {
  public $channelId;
  public $title;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class ImageSettings extends Model {
  protected $__backgroundImageUrlType = 'LocalizedProperty';
  protected $__backgroundImageUrlDataType = '';
  public $backgroundImageUrl;
  public $bannerExternalUrl;
  public $bannerImageUrl;
  public $bannerMobileExtraHdImageUrl;
  public $bannerMobileHdImageUrl;
  public $bannerMobileImageUrl;
  public $bannerMobileLowImageUrl;
  public $bannerMobileMediumHdImageUrl;
  public $bannerTabletExtraHdImageUrl;
  public $bannerTabletHdImageUrl;
  public $bannerTabletImageUrl;
  public $bannerTabletLowImageUrl;
  public $bannerTvImageUrl;
  protected $__largeBrandedBannerImageImapScriptType = 'LocalizedProperty';
  protected $__largeBrandedBannerImageImapScriptDataType = '';
  public $largeBrandedBannerImageImapScript;
  protected $__largeBrandedBannerImageUrlType = 'LocalizedProperty';
  protected $__largeBrandedBannerImageUrlDataType = '';
  public $largeBrandedBannerImageUrl;
  protected $__smallBrandedBannerImageImapScriptType = 'LocalizedProperty';
  protected $__smallBrandedBannerImageImapScriptDataType = '';
  public $smallBrandedBannerImageImapScript;
  protected $__smallBrandedBannerImageUrlType = 'LocalizedProperty';
  protected $__smallBrandedBannerImageUrlDataType = '';
  public $smallBrandedBannerImageUrl;
  public $trackingImageUrl;
  public $watchIconImageUrl;
  public function setBackgroundImageUrl(LocalizedProperty $backgroundImageUrl) {
    $this->backgroundImageUrl = $backgroundImageUrl;
  }
  public function getBackgroundImageUrl() {
    return $this->backgroundImageUrl;
  }
  public function setBannerExternalUrl( $bannerExternalUrl) {
    $this->bannerExternalUrl = $bannerExternalUrl;
  }
  public function getBannerExternalUrl() {
    return $this->bannerExternalUrl;
  }
  public function setBannerImageUrl( $bannerImageUrl) {
    $this->bannerImageUrl = $bannerImageUrl;
  }
  public function getBannerImageUrl() {
    return $this->bannerImageUrl;
  }
  public function setBannerMobileExtraHdImageUrl( $bannerMobileExtraHdImageUrl) {
    $this->bannerMobileExtraHdImageUrl = $bannerMobileExtraHdImageUrl;
  }
  public function getBannerMobileExtraHdImageUrl() {
    return $this->bannerMobileExtraHdImageUrl;
  }
  public function setBannerMobileHdImageUrl( $bannerMobileHdImageUrl) {
    $this->bannerMobileHdImageUrl = $bannerMobileHdImageUrl;
  }
  public function getBannerMobileHdImageUrl() {
    return $this->bannerMobileHdImageUrl;
  }
  public function setBannerMobileImageUrl( $bannerMobileImageUrl) {
    $this->bannerMobileImageUrl = $bannerMobileImageUrl;
  }
  public function getBannerMobileImageUrl() {
    return $this->bannerMobileImageUrl;
  }
  public function setBannerMobileLowImageUrl( $bannerMobileLowImageUrl) {
    $this->bannerMobileLowImageUrl = $bannerMobileLowImageUrl;
  }
  public function getBannerMobileLowImageUrl() {
    return $this->bannerMobileLowImageUrl;
  }
  public function setBannerMobileMediumHdImageUrl( $bannerMobileMediumHdImageUrl) {
    $this->bannerMobileMediumHdImageUrl = $bannerMobileMediumHdImageUrl;
  }
  public function getBannerMobileMediumHdImageUrl() {
    return $this->bannerMobileMediumHdImageUrl;
  }
  public function setBannerTabletExtraHdImageUrl( $bannerTabletExtraHdImageUrl) {
    $this->bannerTabletExtraHdImageUrl = $bannerTabletExtraHdImageUrl;
  }
  public function getBannerTabletExtraHdImageUrl() {
    return $this->bannerTabletExtraHdImageUrl;
  }
  public function setBannerTabletHdImageUrl( $bannerTabletHdImageUrl) {
    $this->bannerTabletHdImageUrl = $bannerTabletHdImageUrl;
  }
  public function getBannerTabletHdImageUrl() {
    return $this->bannerTabletHdImageUrl;
  }
  public function setBannerTabletImageUrl( $bannerTabletImageUrl) {
    $this->bannerTabletImageUrl = $bannerTabletImageUrl;
  }
  public function getBannerTabletImageUrl() {
    return $this->bannerTabletImageUrl;
  }
  public function setBannerTabletLowImageUrl( $bannerTabletLowImageUrl) {
    $this->bannerTabletLowImageUrl = $bannerTabletLowImageUrl;
  }
  public function getBannerTabletLowImageUrl() {
    return $this->bannerTabletLowImageUrl;
  }
  public function setBannerTvImageUrl( $bannerTvImageUrl) {
    $this->bannerTvImageUrl = $bannerTvImageUrl;
  }
  public function getBannerTvImageUrl() {
    return $this->bannerTvImageUrl;
  }
  public function setLargeBrandedBannerImageImapScript(LocalizedProperty $largeBrandedBannerImageImapScript) {
    $this->largeBrandedBannerImageImapScript = $largeBrandedBannerImageImapScript;
  }
  public function getLargeBrandedBannerImageImapScript() {
    return $this->largeBrandedBannerImageImapScript;
  }
  public function setLargeBrandedBannerImageUrl(LocalizedProperty $largeBrandedBannerImageUrl) {
    $this->largeBrandedBannerImageUrl = $largeBrandedBannerImageUrl;
  }
  public function getLargeBrandedBannerImageUrl() {
    return $this->largeBrandedBannerImageUrl;
  }
  public function setSmallBrandedBannerImageImapScript(LocalizedProperty $smallBrandedBannerImageImapScript) {
    $this->smallBrandedBannerImageImapScript = $smallBrandedBannerImageImapScript;
  }
  public function getSmallBrandedBannerImageImapScript() {
    return $this->smallBrandedBannerImageImapScript;
  }
  public function setSmallBrandedBannerImageUrl(LocalizedProperty $smallBrandedBannerImageUrl) {
    $this->smallBrandedBannerImageUrl = $smallBrandedBannerImageUrl;
  }
  public function getSmallBrandedBannerImageUrl() {
    return $this->smallBrandedBannerImageUrl;
  }
  public function setTrackingImageUrl( $trackingImageUrl) {
    $this->trackingImageUrl = $trackingImageUrl;
  }
  public function getTrackingImageUrl() {
    return $this->trackingImageUrl;
  }
  public function setWatchIconImageUrl( $watchIconImageUrl) {
    $this->watchIconImageUrl = $watchIconImageUrl;
  }
  public function getWatchIconImageUrl() {
    return $this->watchIconImageUrl;
  }
}

class IngestionInfo extends Model {
  public $backupIngestionAddress;
  public $ingestionAddress;
  public $streamName;
  public function setBackupIngestionAddress( $backupIngestionAddress) {
    $this->backupIngestionAddress = $backupIngestionAddress;
  }
  public function getBackupIngestionAddress() {
    return $this->backupIngestionAddress;
  }
  public function setIngestionAddress( $ingestionAddress) {
    $this->ingestionAddress = $ingestionAddress;
  }
  public function getIngestionAddress() {
    return $this->ingestionAddress;
  }
  public function setStreamName( $streamName) {
    $this->streamName = $streamName;
  }
  public function getStreamName() {
    return $this->streamName;
  }
}

class InvideoPosition extends Model {
  public $cornerPosition;
  public $type;
  public function setCornerPosition( $cornerPosition) {
    $this->cornerPosition = $cornerPosition;
  }
  public function getCornerPosition() {
    return $this->cornerPosition;
  }
  public function setType( $type) {
    $this->type = $type;
  }
  public function getType() {
    return $this->type;
  }
}

class InvideoPromotion extends Model {
  protected $__itemsType = 'PromotedItemId';
  protected $__itemsDataType = 'array';
  public $items;
  protected $__positionType = 'InvideoPosition';
  protected $__positionDataType = '';
  public $position;
  protected $__timingType = 'InvideoTiming';
  protected $__timingDataType = '';
  public $timing;
  public function setItems(/* array(PromotedItemId) */ $items) {
    $this->assertIsArray($items, 'PromotedItemId', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setPosition(InvideoPosition $position) {
    $this->position = $position;
  }
  public function getPosition() {
    return $this->position;
  }
  public function setTiming(InvideoTiming $timing) {
    $this->timing = $timing;
  }
  public function getTiming() {
    return $this->timing;
  }
}

class InvideoTiming extends Model {
  public $offsetMs;
  public $type;
  public function setOffsetMs( $offsetMs) {
    $this->offsetMs = $offsetMs;
  }
  public function getOffsetMs() {
    return $this->offsetMs;
  }
  public function setType( $type) {
    $this->type = $type;
  }
  public function getType() {
    return $this->type;
  }
}

class LiveBroadcast extends Model {
  protected $__contentDetailsType = 'LiveBroadcastContentDetails';
  protected $__contentDetailsDataType = '';
  public $contentDetails;
  public $etag;
  public $id;
  public $kind;
  protected $__snippetType = 'LiveBroadcastSnippet';
  protected $__snippetDataType = '';
  public $snippet;
  protected $__statusType = 'LiveBroadcastStatus';
  protected $__statusDataType = '';
  public $status;
  public function setContentDetails(LiveBroadcastContentDetails $contentDetails) {
    $this->contentDetails = $contentDetails;
  }
  public function getContentDetails() {
    return $this->contentDetails;
  }
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setSnippet(LiveBroadcastSnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
  public function setStatus(LiveBroadcastStatus $status) {
    $this->status = $status;
  }
  public function getStatus() {
    return $this->status;
  }
}

class LiveBroadcastContentDetails extends Model {
  public $boundStreamId;
  public $enableContentEncryption;
  public $enableDvr;
  public $enableEmbed;
  protected $__monitorStreamType = 'MonitorStreamInfo';
  protected $__monitorStreamDataType = '';
  public $monitorStream;
  public $recordFromStart;
  public $startWithSlate;
  public function setBoundStreamId( $boundStreamId) {
    $this->boundStreamId = $boundStreamId;
  }
  public function getBoundStreamId() {
    return $this->boundStreamId;
  }
  public function setEnableContentEncryption( $enableContentEncryption) {
    $this->enableContentEncryption = $enableContentEncryption;
  }
  public function getEnableContentEncryption() {
    return $this->enableContentEncryption;
  }
  public function setEnableDvr( $enableDvr) {
    $this->enableDvr = $enableDvr;
  }
  public function getEnableDvr() {
    return $this->enableDvr;
  }
  public function setEnableEmbed( $enableEmbed) {
    $this->enableEmbed = $enableEmbed;
  }
  public function getEnableEmbed() {
    return $this->enableEmbed;
  }
  public function setMonitorStream(MonitorStreamInfo $monitorStream) {
    $this->monitorStream = $monitorStream;
  }
  public function getMonitorStream() {
    return $this->monitorStream;
  }
  public function setRecordFromStart( $recordFromStart) {
    $this->recordFromStart = $recordFromStart;
  }
  public function getRecordFromStart() {
    return $this->recordFromStart;
  }
  public function setStartWithSlate( $startWithSlate) {
    $this->startWithSlate = $startWithSlate;
  }
  public function getStartWithSlate() {
    return $this->startWithSlate;
  }
}

class LiveBroadcastList extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'LiveBroadcast';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $nextPageToken;
  protected $__pageInfoType = 'PageInfo';
  protected $__pageInfoDataType = '';
  public $pageInfo;
  public $prevPageToken;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(LiveBroadcast) */ $items) {
    $this->assertIsArray($items, 'LiveBroadcast', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setNextPageToken( $nextPageToken) {
    $this->nextPageToken = $nextPageToken;
  }
  public function getNextPageToken() {
    return $this->nextPageToken;
  }
  public function setPageInfo(PageInfo $pageInfo) {
    $this->pageInfo = $pageInfo;
  }
  public function getPageInfo() {
    return $this->pageInfo;
  }
  public function setPrevPageToken( $prevPageToken) {
    $this->prevPageToken = $prevPageToken;
  }
  public function getPrevPageToken() {
    return $this->prevPageToken;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class LiveBroadcastSnippet extends Model {
  public $actualEndTime;
  public $actualStartTime;
  public $channelId;
  public $description;
  public $publishedAt;
  public $scheduledEndTime;
  public $scheduledStartTime;
  protected $__thumbnailsType = 'ThumbnailDetails';
  protected $__thumbnailsDataType = '';
  public $thumbnails;
  public $title;
  public function setActualEndTime( $actualEndTime) {
    $this->actualEndTime = $actualEndTime;
  }
  public function getActualEndTime() {
    return $this->actualEndTime;
  }
  public function setActualStartTime( $actualStartTime) {
    $this->actualStartTime = $actualStartTime;
  }
  public function getActualStartTime() {
    return $this->actualStartTime;
  }
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setPublishedAt( $publishedAt) {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt() {
    return $this->publishedAt;
  }
  public function setScheduledEndTime( $scheduledEndTime) {
    $this->scheduledEndTime = $scheduledEndTime;
  }
  public function getScheduledEndTime() {
    return $this->scheduledEndTime;
  }
  public function setScheduledStartTime( $scheduledStartTime) {
    $this->scheduledStartTime = $scheduledStartTime;
  }
  public function getScheduledStartTime() {
    return $this->scheduledStartTime;
  }
  public function setThumbnails(ThumbnailDetails $thumbnails) {
    $this->thumbnails = $thumbnails;
  }
  public function getThumbnails() {
    return $this->thumbnails;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class LiveBroadcastStatus extends Model {
  public $lifeCycleStatus;
  public $privacyStatus;
  public $recordingStatus;
  public function setLifeCycleStatus( $lifeCycleStatus) {
    $this->lifeCycleStatus = $lifeCycleStatus;
  }
  public function getLifeCycleStatus() {
    return $this->lifeCycleStatus;
  }
  public function setPrivacyStatus( $privacyStatus) {
    $this->privacyStatus = $privacyStatus;
  }
  public function getPrivacyStatus() {
    return $this->privacyStatus;
  }
  public function setRecordingStatus( $recordingStatus) {
    $this->recordingStatus = $recordingStatus;
  }
  public function getRecordingStatus() {
    return $this->recordingStatus;
  }
}

class LiveStream extends Model {
  protected $__cdnType = 'LiveStreamCdn';
  protected $__cdnDataType = '';
  public $cdn;
  public $etag;
  public $id;
  public $kind;
  protected $__snippetType = 'LiveStreamSnippet';
  protected $__snippetDataType = '';
  public $snippet;
  protected $__statusType = 'LiveStreamStatus';
  protected $__statusDataType = '';
  public $status;
  public function setCdn(LiveStreamCdn $cdn) {
    $this->cdn = $cdn;
  }
  public function getCdn() {
    return $this->cdn;
  }
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setSnippet(LiveStreamSnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
  public function setStatus(LiveStreamStatus $status) {
    $this->status = $status;
  }
  public function getStatus() {
    return $this->status;
  }
}

class LiveStreamCdn extends Model {
  public $format;
  protected $__ingestionInfoType = 'IngestionInfo';
  protected $__ingestionInfoDataType = '';
  public $ingestionInfo;
  public $ingestionType;
  public function setFormat( $format) {
    $this->format = $format;
  }
  public function getFormat() {
    return $this->format;
  }
  public function setIngestionInfo(IngestionInfo $ingestionInfo) {
    $this->ingestionInfo = $ingestionInfo;
  }
  public function getIngestionInfo() {
    return $this->ingestionInfo;
  }
  public function setIngestionType( $ingestionType) {
    $this->ingestionType = $ingestionType;
  }
  public function getIngestionType() {
    return $this->ingestionType;
  }
}

class LiveStreamList extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'LiveStream';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $nextPageToken;
  protected $__pageInfoType = 'PageInfo';
  protected $__pageInfoDataType = '';
  public $pageInfo;
  public $prevPageToken;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(LiveStream) */ $items) {
    $this->assertIsArray($items, 'LiveStream', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setNextPageToken( $nextPageToken) {
    $this->nextPageToken = $nextPageToken;
  }
  public function getNextPageToken() {
    return $this->nextPageToken;
  }
  public function setPageInfo(PageInfo $pageInfo) {
    $this->pageInfo = $pageInfo;
  }
  public function getPageInfo() {
    return $this->pageInfo;
  }
  public function setPrevPageToken( $prevPageToken) {
    $this->prevPageToken = $prevPageToken;
  }
  public function getPrevPageToken() {
    return $this->prevPageToken;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class LiveStreamSnippet extends Model {
  public $channelId;
  public $description;
  public $publishedAt;
  public $title;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setPublishedAt( $publishedAt) {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt() {
    return $this->publishedAt;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class LiveStreamStatus extends Model {
  public $streamStatus;
  public function setStreamStatus( $streamStatus) {
    $this->streamStatus = $streamStatus;
  }
  public function getStreamStatus() {
    return $this->streamStatus;
  }
}

class LocalizedProperty extends Model {
  public $default;
  protected $__localizedType = 'LocalizedString';
  protected $__localizedDataType = 'array';
  public $localized;
  public function setDefault( $default) {
    $this->default = $default;
  }
  public function getDefault() {
    return $this->default;
  }
  public function setLocalized(/* array(LocalizedString) */ $localized) {
    $this->assertIsArray($localized, 'LocalizedString', __METHOD__);
    $this->localized = $localized;
  }
  public function getLocalized() {
    return $this->localized;
  }
}

class LocalizedString extends Model {
  public $language;
  public $value;
  public function setLanguage( $language) {
    $this->language = $language;
  }
  public function getLanguage() {
    return $this->language;
  }
  public function setValue( $value) {
    $this->value = $value;
  }
  public function getValue() {
    return $this->value;
  }
}

class MonitorStreamInfo extends Model {
  public $broadcastStreamDelayMs;
  public $embedHtml;
  public $enableMonitorStream;
  public function setBroadcastStreamDelayMs( $broadcastStreamDelayMs) {
    $this->broadcastStreamDelayMs = $broadcastStreamDelayMs;
  }
  public function getBroadcastStreamDelayMs() {
    return $this->broadcastStreamDelayMs;
  }
  public function setEmbedHtml( $embedHtml) {
    $this->embedHtml = $embedHtml;
  }
  public function getEmbedHtml() {
    return $this->embedHtml;
  }
  public function setEnableMonitorStream( $enableMonitorStream) {
    $this->enableMonitorStream = $enableMonitorStream;
  }
  public function getEnableMonitorStream() {
    return $this->enableMonitorStream;
  }
}

class PageInfo extends Model {
  public $resultsPerPage;
  public $totalResults;
  public function setResultsPerPage( $resultsPerPage) {
    $this->resultsPerPage = $resultsPerPage;
  }
  public function getResultsPerPage() {
    return $this->resultsPerPage;
  }
  public function setTotalResults( $totalResults) {
    $this->totalResults = $totalResults;
  }
  public function getTotalResults() {
    return $this->totalResults;
  }
}

class Playlist extends Model {
  protected $__contentDetailsType = 'PlaylistContentDetails';
  protected $__contentDetailsDataType = '';
  public $contentDetails;
  public $etag;
  public $id;
  public $kind;
  protected $__playerType = 'PlaylistPlayer';
  protected $__playerDataType = '';
  public $player;
  protected $__snippetType = 'PlaylistSnippet';
  protected $__snippetDataType = '';
  public $snippet;
  protected $__statusType = 'PlaylistStatus';
  protected $__statusDataType = '';
  public $status;
  public function setContentDetails(PlaylistContentDetails $contentDetails) {
    $this->contentDetails = $contentDetails;
  }
  public function getContentDetails() {
    return $this->contentDetails;
  }
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setPlayer(PlaylistPlayer $player) {
    $this->player = $player;
  }
  public function getPlayer() {
    return $this->player;
  }
  public function setSnippet(PlaylistSnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
  public function setStatus(PlaylistStatus $status) {
    $this->status = $status;
  }
  public function getStatus() {
    return $this->status;
  }
}

class PlaylistContentDetails extends Model {
  public $itemCount;
  public function setItemCount( $itemCount) {
    $this->itemCount = $itemCount;
  }
  public function getItemCount() {
    return $this->itemCount;
  }
}

class PlaylistItem extends Model {
  protected $__contentDetailsType = 'PlaylistItemContentDetails';
  protected $__contentDetailsDataType = '';
  public $contentDetails;
  public $etag;
  public $id;
  public $kind;
  protected $__snippetType = 'PlaylistItemSnippet';
  protected $__snippetDataType = '';
  public $snippet;
  protected $__statusType = 'PlaylistItemStatus';
  protected $__statusDataType = '';
  public $status;
  public function setContentDetails(PlaylistItemContentDetails $contentDetails) {
    $this->contentDetails = $contentDetails;
  }
  public function getContentDetails() {
    return $this->contentDetails;
  }
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setSnippet(PlaylistItemSnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
  public function setStatus(PlaylistItemStatus $status) {
    $this->status = $status;
  }
  public function getStatus() {
    return $this->status;
  }
}

class PlaylistItemContentDetails extends Model {
  public $endAtMs;
  public $note;
  public $startAtMs;
  public $videoId;
  public function setEndAtMs( $endAtMs) {
    $this->endAtMs = $endAtMs;
  }
  public function getEndAtMs() {
    return $this->endAtMs;
  }
  public function setNote( $note) {
    $this->note = $note;
  }
  public function getNote() {
    return $this->note;
  }
  public function setStartAtMs( $startAtMs) {
    $this->startAtMs = $startAtMs;
  }
  public function getStartAtMs() {
    return $this->startAtMs;
  }
  public function setVideoId( $videoId) {
    $this->videoId = $videoId;
  }
  public function getVideoId() {
    return $this->videoId;
  }
}

class PlaylistItemListResponse extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'PlaylistItem';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $nextPageToken;
  protected $__pageInfoType = 'PageInfo';
  protected $__pageInfoDataType = '';
  public $pageInfo;
  public $prevPageToken;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(PlaylistItem) */ $items) {
    $this->assertIsArray($items, 'PlaylistItem', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setNextPageToken( $nextPageToken) {
    $this->nextPageToken = $nextPageToken;
  }
  public function getNextPageToken() {
    return $this->nextPageToken;
  }
  public function setPageInfo(PageInfo $pageInfo) {
    $this->pageInfo = $pageInfo;
  }
  public function getPageInfo() {
    return $this->pageInfo;
  }
  public function setPrevPageToken( $prevPageToken) {
    $this->prevPageToken = $prevPageToken;
  }
  public function getPrevPageToken() {
    return $this->prevPageToken;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class PlaylistItemSnippet extends Model {
  public $channelId;
  public $channelTitle;
  public $description;
  public $playlistId;
  public $position;
  public $publishedAt;
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  protected $__thumbnailsType = 'ThumbnailDetails';
  protected $__thumbnailsDataType = '';
  public $thumbnails;
  public $title;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setChannelTitle( $channelTitle) {
    $this->channelTitle = $channelTitle;
  }
  public function getChannelTitle() {
    return $this->channelTitle;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setPlaylistId( $playlistId) {
    $this->playlistId = $playlistId;
  }
  public function getPlaylistId() {
    return $this->playlistId;
  }
  public function setPosition( $position) {
    $this->position = $position;
  }
  public function getPosition() {
    return $this->position;
  }
  public function setPublishedAt( $publishedAt) {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt() {
    return $this->publishedAt;
  }
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
  public function setThumbnails(ThumbnailDetails $thumbnails) {
    $this->thumbnails = $thumbnails;
  }
  public function getThumbnails() {
    return $this->thumbnails;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class PlaylistItemStatus extends Model {
  public $privacyStatus;
  public function setPrivacyStatus( $privacyStatus) {
    $this->privacyStatus = $privacyStatus;
  }
  public function getPrivacyStatus() {
    return $this->privacyStatus;
  }
}

class PlaylistListResponse extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'Playlist';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $nextPageToken;
  protected $__pageInfoType = 'PageInfo';
  protected $__pageInfoDataType = '';
  public $pageInfo;
  public $prevPageToken;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(Playlist) */ $items) {
    $this->assertIsArray($items, 'Playlist', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setNextPageToken( $nextPageToken) {
    $this->nextPageToken = $nextPageToken;
  }
  public function getNextPageToken() {
    return $this->nextPageToken;
  }
  public function setPageInfo(PageInfo $pageInfo) {
    $this->pageInfo = $pageInfo;
  }
  public function getPageInfo() {
    return $this->pageInfo;
  }
  public function setPrevPageToken( $prevPageToken) {
    $this->prevPageToken = $prevPageToken;
  }
  public function getPrevPageToken() {
    return $this->prevPageToken;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class PlaylistPlayer extends Model {
  public $embedHtml;
  public function setEmbedHtml( $embedHtml) {
    $this->embedHtml = $embedHtml;
  }
  public function getEmbedHtml() {
    return $this->embedHtml;
  }
}

class PlaylistSnippet extends Model {
  public $channelId;
  public $channelTitle;
  public $description;
  public $publishedAt;
  public $tags;
  protected $__thumbnailsType = 'ThumbnailDetails';
  protected $__thumbnailsDataType = '';
  public $thumbnails;
  public $title;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setChannelTitle( $channelTitle) {
    $this->channelTitle = $channelTitle;
  }
  public function getChannelTitle() {
    return $this->channelTitle;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setPublishedAt( $publishedAt) {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt() {
    return $this->publishedAt;
  }
  public function setTags(/* array(string) */ $tags) {
    $this->assertIsArray($tags, 'string', __METHOD__);
    $this->tags = $tags;
  }
  public function getTags() {
    return $this->tags;
  }
  public function setThumbnails(ThumbnailDetails $thumbnails) {
    $this->thumbnails = $thumbnails;
  }
  public function getThumbnails() {
    return $this->thumbnails;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class PlaylistStatus extends Model {
  public $privacyStatus;
  public function setPrivacyStatus( $privacyStatus) {
    $this->privacyStatus = $privacyStatus;
  }
  public function getPrivacyStatus() {
    return $this->privacyStatus;
  }
}

class PromotedItemId extends Model {
  public $type;
  public $videoId;
  public function setType( $type) {
    $this->type = $type;
  }
  public function getType() {
    return $this->type;
  }
  public function setVideoId( $videoId) {
    $this->videoId = $videoId;
  }
  public function getVideoId() {
    return $this->videoId;
  }
}

class PropertyValue extends Model {
  public $property;
  public $value;
  public function setProperty( $property) {
    $this->property = $property;
  }
  public function getProperty() {
    return $this->property;
  }
  public function setValue( $value) {
    $this->value = $value;
  }
  public function getValue() {
    return $this->value;
  }
}

class ResourceId extends Model {
  public $channelId;
  public $kind;
  public $playlistId;
  public $videoId;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setPlaylistId( $playlistId) {
    $this->playlistId = $playlistId;
  }
  public function getPlaylistId() {
    return $this->playlistId;
  }
  public function setVideoId( $videoId) {
    $this->videoId = $videoId;
  }
  public function getVideoId() {
    return $this->videoId;
  }
}

class SearchListResponse extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'SearchResult';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $nextPageToken;
  protected $__pageInfoType = 'PageInfo';
  protected $__pageInfoDataType = '';
  public $pageInfo;
  public $prevPageToken;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(SearchResult) */ $items) {
    $this->assertIsArray($items, 'SearchResult', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setNextPageToken( $nextPageToken) {
    $this->nextPageToken = $nextPageToken;
  }
  public function getNextPageToken() {
    return $this->nextPageToken;
  }
  public function setPageInfo(PageInfo $pageInfo) {
    $this->pageInfo = $pageInfo;
  }
  public function getPageInfo() {
    return $this->pageInfo;
  }
  public function setPrevPageToken( $prevPageToken) {
    $this->prevPageToken = $prevPageToken;
  }
  public function getPrevPageToken() {
    return $this->prevPageToken;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class SearchResult extends Model {
  public $etag;
  protected $__idType = 'ResourceId';
  protected $__idDataType = '';
  public $id;
  public $kind;
  protected $__snippetType = 'SearchResultSnippet';
  protected $__snippetDataType = '';
  public $snippet;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId(ResourceId $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setSnippet(SearchResultSnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
}

class SearchResultSnippet extends Model {
  public $channelId;
  public $channelTitle;
  public $description;
  public $publishedAt;
  protected $__thumbnailsType = 'ThumbnailDetails';
  protected $__thumbnailsDataType = '';
  public $thumbnails;
  public $title;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setChannelTitle( $channelTitle) {
    $this->channelTitle = $channelTitle;
  }
  public function getChannelTitle() {
    return $this->channelTitle;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setPublishedAt( $publishedAt) {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt() {
    return $this->publishedAt;
  }
  public function setThumbnails(ThumbnailDetails $thumbnails) {
    $this->thumbnails = $thumbnails;
  }
  public function getThumbnails() {
    return $this->thumbnails;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class Subscription extends Model {
  protected $__contentDetailsType = 'SubscriptionContentDetails';
  protected $__contentDetailsDataType = '';
  public $contentDetails;
  public $etag;
  public $id;
  public $kind;
  protected $__snippetType = 'SubscriptionSnippet';
  protected $__snippetDataType = '';
  public $snippet;
  protected $__subscriberSnippetType = 'SubscriptionSubscriberSnippet';
  protected $__subscriberSnippetDataType = '';
  public $subscriberSnippet;
  public function setContentDetails(SubscriptionContentDetails $contentDetails) {
    $this->contentDetails = $contentDetails;
  }
  public function getContentDetails() {
    return $this->contentDetails;
  }
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setSnippet(SubscriptionSnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
  public function setSubscriberSnippet(SubscriptionSubscriberSnippet $subscriberSnippet) {
    $this->subscriberSnippet = $subscriberSnippet;
  }
  public function getSubscriberSnippet() {
    return $this->subscriberSnippet;
  }
}

class SubscriptionContentDetails extends Model {
  public $activityType;
  public $newItemCount;
  public $totalItemCount;
  public function setActivityType( $activityType) {
    $this->activityType = $activityType;
  }
  public function getActivityType() {
    return $this->activityType;
  }
  public function setNewItemCount( $newItemCount) {
    $this->newItemCount = $newItemCount;
  }
  public function getNewItemCount() {
    return $this->newItemCount;
  }
  public function setTotalItemCount( $totalItemCount) {
    $this->totalItemCount = $totalItemCount;
  }
  public function getTotalItemCount() {
    return $this->totalItemCount;
  }
}

class SubscriptionListResponse extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'Subscription';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $nextPageToken;
  protected $__pageInfoType = 'PageInfo';
  protected $__pageInfoDataType = '';
  public $pageInfo;
  public $prevPageToken;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(Subscription) */ $items) {
    $this->assertIsArray($items, 'Subscription', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setNextPageToken( $nextPageToken) {
    $this->nextPageToken = $nextPageToken;
  }
  public function getNextPageToken() {
    return $this->nextPageToken;
  }
  public function setPageInfo(PageInfo $pageInfo) {
    $this->pageInfo = $pageInfo;
  }
  public function getPageInfo() {
    return $this->pageInfo;
  }
  public function setPrevPageToken( $prevPageToken) {
    $this->prevPageToken = $prevPageToken;
  }
  public function getPrevPageToken() {
    return $this->prevPageToken;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class SubscriptionSnippet extends Model {
  public $channelId;
  public $channelTitle;
  public $description;
  public $publishedAt;
  protected $__resourceIdType = 'ResourceId';
  protected $__resourceIdDataType = '';
  public $resourceId;
  protected $__thumbnailsType = 'ThumbnailDetails';
  protected $__thumbnailsDataType = '';
  public $thumbnails;
  public $title;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setChannelTitle( $channelTitle) {
    $this->channelTitle = $channelTitle;
  }
  public function getChannelTitle() {
    return $this->channelTitle;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setPublishedAt( $publishedAt) {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt() {
    return $this->publishedAt;
  }
  public function setResourceId(ResourceId $resourceId) {
    $this->resourceId = $resourceId;
  }
  public function getResourceId() {
    return $this->resourceId;
  }
  public function setThumbnails(ThumbnailDetails $thumbnails) {
    $this->thumbnails = $thumbnails;
  }
  public function getThumbnails() {
    return $this->thumbnails;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class SubscriptionSubscriberSnippet extends Model {
  public $channelId;
  public $description;
  protected $__thumbnailsType = 'ThumbnailDetails';
  protected $__thumbnailsDataType = '';
  public $thumbnails;
  public $title;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setThumbnails(ThumbnailDetails $thumbnails) {
    $this->thumbnails = $thumbnails;
  }
  public function getThumbnails() {
    return $this->thumbnails;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class Thumbnail extends Model {
  public $height;
  public $url;
  public $width;
  public function setHeight( $height) {
    $this->height = $height;
  }
  public function getHeight() {
    return $this->height;
  }
  public function setUrl( $url) {
    $this->url = $url;
  }
  public function getUrl() {
    return $this->url;
  }
  public function setWidth( $width) {
    $this->width = $width;
  }
  public function getWidth() {
    return $this->width;
  }
}

class ThumbnailDetails extends Model {
  protected $__defaultType = 'Thumbnail';
  protected $__defaultDataType = '';
  public $default;
  protected $__highType = 'Thumbnail';
  protected $__highDataType = '';
  public $high;
  protected $__maxresType = 'Thumbnail';
  protected $__maxresDataType = '';
  public $maxres;
  protected $__mediumType = 'Thumbnail';
  protected $__mediumDataType = '';
  public $medium;
  protected $__standardType = 'Thumbnail';
  protected $__standardDataType = '';
  public $standard;
  public function setDefault(Thumbnail $default) {
    $this->default = $default;
  }
  public function getDefault() {
    return $this->default;
  }
  public function setHigh(Thumbnail $high) {
    $this->high = $high;
  }
  public function getHigh() {
    return $this->high;
  }
  public function setMaxres(Thumbnail $maxres) {
    $this->maxres = $maxres;
  }
  public function getMaxres() {
    return $this->maxres;
  }
  public function setMedium(Thumbnail $medium) {
    $this->medium = $medium;
  }
  public function getMedium() {
    return $this->medium;
  }
  public function setStandard(Thumbnail $standard) {
    $this->standard = $standard;
  }
  public function getStandard() {
    return $this->standard;
  }
}

class ThumbnailListResponse extends Model {
  public $etag;
  protected $__itemsType = 'ThumbnailDetails';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setItems(/* array(ThumbnailDetails) */ $items) {
    $this->assertIsArray($items, 'ThumbnailDetails', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class Video extends Model {
  protected $__ageGatingType = 'VideoAgeGating';
  protected $__ageGatingDataType = '';
  public $ageGating;
  protected $__contentDetailsType = 'VideoContentDetails';
  protected $__contentDetailsDataType = '';
  public $contentDetails;
  protected $__conversionPingsType = 'VideoConversionPings';
  protected $__conversionPingsDataType = '';
  public $conversionPings;
  public $etag;
  protected $__fileDetailsType = 'VideoFileDetails';
  protected $__fileDetailsDataType = '';
  public $fileDetails;
  public $id;
  public $kind;
  protected $__monetizationDetailsType = 'VideoMonetizationDetails';
  protected $__monetizationDetailsDataType = '';
  public $monetizationDetails;
  protected $__playerType = 'VideoPlayer';
  protected $__playerDataType = '';
  public $player;
  protected $__processingDetailsType = 'VideoProcessingDetails';
  protected $__processingDetailsDataType = '';
  public $processingDetails;
  protected $__projectDetailsType = 'VideoProjectDetails';
  protected $__projectDetailsDataType = '';
  public $projectDetails;
  protected $__recordingDetailsType = 'VideoRecordingDetails';
  protected $__recordingDetailsDataType = '';
  public $recordingDetails;
  protected $__snippetType = 'VideoSnippet';
  protected $__snippetDataType = '';
  public $snippet;
  protected $__statisticsType = 'VideoStatistics';
  protected $__statisticsDataType = '';
  public $statistics;
  protected $__statusType = 'VideoStatus';
  protected $__statusDataType = '';
  public $status;
  protected $__suggestionsType = 'VideoSuggestions';
  protected $__suggestionsDataType = '';
  public $suggestions;
  protected $__topicDetailsType = 'VideoTopicDetails';
  protected $__topicDetailsDataType = '';
  public $topicDetails;
  public function setAgeGating(VideoAgeGating $ageGating) {
    $this->ageGating = $ageGating;
  }
  public function getAgeGating() {
    return $this->ageGating;
  }
  public function setContentDetails(VideoContentDetails $contentDetails) {
    $this->contentDetails = $contentDetails;
  }
  public function getContentDetails() {
    return $this->contentDetails;
  }
  public function setConversionPings(VideoConversionPings $conversionPings) {
    $this->conversionPings = $conversionPings;
  }
  public function getConversionPings() {
    return $this->conversionPings;
  }
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setFileDetails(VideoFileDetails $fileDetails) {
    $this->fileDetails = $fileDetails;
  }
  public function getFileDetails() {
    return $this->fileDetails;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setMonetizationDetails(VideoMonetizationDetails $monetizationDetails) {
    $this->monetizationDetails = $monetizationDetails;
  }
  public function getMonetizationDetails() {
    return $this->monetizationDetails;
  }
  public function setPlayer(VideoPlayer $player) {
    $this->player = $player;
  }
  public function getPlayer() {
    return $this->player;
  }
  public function setProcessingDetails(VideoProcessingDetails $processingDetails) {
    $this->processingDetails = $processingDetails;
  }
  public function getProcessingDetails() {
    return $this->processingDetails;
  }
  public function setProjectDetails(VideoProjectDetails $projectDetails) {
    $this->projectDetails = $projectDetails;
  }
  public function getProjectDetails() {
    return $this->projectDetails;
  }
  public function setRecordingDetails(VideoRecordingDetails $recordingDetails) {
    $this->recordingDetails = $recordingDetails;
  }
  public function getRecordingDetails() {
    return $this->recordingDetails;
  }
  public function setSnippet(VideoSnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
  public function setStatistics(VideoStatistics $statistics) {
    $this->statistics = $statistics;
  }
  public function getStatistics() {
    return $this->statistics;
  }
  public function setStatus(VideoStatus $status) {
    $this->status = $status;
  }
  public function getStatus() {
    return $this->status;
  }
  public function setSuggestions(VideoSuggestions $suggestions) {
    $this->suggestions = $suggestions;
  }
  public function getSuggestions() {
    return $this->suggestions;
  }
  public function setTopicDetails(VideoTopicDetails $topicDetails) {
    $this->topicDetails = $topicDetails;
  }
  public function getTopicDetails() {
    return $this->topicDetails;
  }
}

class VideoAgeGating extends Model {
  public $alcoholContent;
  public $restricted;
  public $videoGameRating;
  public function setAlcoholContent( $alcoholContent) {
    $this->alcoholContent = $alcoholContent;
  }
  public function getAlcoholContent() {
    return $this->alcoholContent;
  }
  public function setRestricted( $restricted) {
    $this->restricted = $restricted;
  }
  public function getRestricted() {
    return $this->restricted;
  }
  public function setVideoGameRating( $videoGameRating) {
    $this->videoGameRating = $videoGameRating;
  }
  public function getVideoGameRating() {
    return $this->videoGameRating;
  }
}

class VideoCategory extends Model {
  public $etag;
  public $id;
  public $kind;
  protected $__snippetType = 'VideoCategorySnippet';
  protected $__snippetDataType = '';
  public $snippet;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setId( $id) {
    $this->id = $id;
  }
  public function getId() {
    return $this->id;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setSnippet(VideoCategorySnippet $snippet) {
    $this->snippet = $snippet;
  }
  public function getSnippet() {
    return $this->snippet;
  }
}

class VideoCategoryListResponse extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'VideoCategory';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(VideoCategory) */ $items) {
    $this->assertIsArray($items, 'VideoCategory', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class VideoCategorySnippet extends Model {
  public $channelId;
  public $title;
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class VideoContentDetails extends Model {
  public $caption;
  protected $__contentRatingType = 'ContentRating';
  protected $__contentRatingDataType = '';
  public $contentRating;
  protected $__countryRestrictionType = 'AccessPolicy';
  protected $__countryRestrictionDataType = '';
  public $countryRestriction;
  public $definition;
  public $dimension;
  public $duration;
  public $licensedContent;
  protected $__regionRestrictionType = 'VideoContentDetailsRegionRestriction';
  protected $__regionRestrictionDataType = '';
  public $regionRestriction;
  public function setCaption( $caption) {
    $this->caption = $caption;
  }
  public function getCaption() {
    return $this->caption;
  }
  public function setContentRating(ContentRating $contentRating) {
    $this->contentRating = $contentRating;
  }
  public function getContentRating() {
    return $this->contentRating;
  }
  public function setCountryRestriction(AccessPolicy $countryRestriction) {
    $this->countryRestriction = $countryRestriction;
  }
  public function getCountryRestriction() {
    return $this->countryRestriction;
  }
  public function setDefinition( $definition) {
    $this->definition = $definition;
  }
  public function getDefinition() {
    return $this->definition;
  }
  public function setDimension( $dimension) {
    $this->dimension = $dimension;
  }
  public function getDimension() {
    return $this->dimension;
  }
  public function setDuration( $duration) {
    $this->duration = $duration;
  }
  public function getDuration() {
    return $this->duration;
  }
  public function setLicensedContent( $licensedContent) {
    $this->licensedContent = $licensedContent;
  }
  public function getLicensedContent() {
    return $this->licensedContent;
  }
  public function setRegionRestriction(VideoContentDetailsRegionRestriction $regionRestriction) {
    $this->regionRestriction = $regionRestriction;
  }
  public function getRegionRestriction() {
    return $this->regionRestriction;
  }
}

class VideoContentDetailsRegionRestriction extends Model {
  public $allowed;
  public $blocked;
  public function setAllowed(/* array(string) */ $allowed) {
    $this->assertIsArray($allowed, 'string', __METHOD__);
    $this->allowed = $allowed;
  }
  public function getAllowed() {
    return $this->allowed;
  }
  public function setBlocked(/* array(string) */ $blocked) {
    $this->assertIsArray($blocked, 'string', __METHOD__);
    $this->blocked = $blocked;
  }
  public function getBlocked() {
    return $this->blocked;
  }
}

class VideoConversionPing extends Model {
  public $context;
  public $conversionUrl;
  public function setContext( $context) {
    $this->context = $context;
  }
  public function getContext() {
    return $this->context;
  }
  public function setConversionUrl( $conversionUrl) {
    $this->conversionUrl = $conversionUrl;
  }
  public function getConversionUrl() {
    return $this->conversionUrl;
  }
}

class VideoConversionPings extends Model {
  protected $__pingsType = 'VideoConversionPing';
  protected $__pingsDataType = 'array';
  public $pings;
  public function setPings(/* array(VideoConversionPing) */ $pings) {
    $this->assertIsArray($pings, 'VideoConversionPing', __METHOD__);
    $this->pings = $pings;
  }
  public function getPings() {
    return $this->pings;
  }
}

class VideoFileDetails extends Model {
  protected $__audioStreamsType = 'VideoFileDetailsAudioStream';
  protected $__audioStreamsDataType = 'array';
  public $audioStreams;
  public $bitrateBps;
  public $container;
  public $creationTime;
  public $durationMs;
  public $fileName;
  public $fileSize;
  public $fileType;
  protected $__recordingLocationType = 'GeoPoint';
  protected $__recordingLocationDataType = '';
  public $recordingLocation;
  protected $__videoStreamsType = 'VideoFileDetailsVideoStream';
  protected $__videoStreamsDataType = 'array';
  public $videoStreams;
  public function setAudioStreams(/* array(VideoFileDetailsAudioStream) */ $audioStreams) {
    $this->assertIsArray($audioStreams, 'VideoFileDetailsAudioStream', __METHOD__);
    $this->audioStreams = $audioStreams;
  }
  public function getAudioStreams() {
    return $this->audioStreams;
  }
  public function setBitrateBps( $bitrateBps) {
    $this->bitrateBps = $bitrateBps;
  }
  public function getBitrateBps() {
    return $this->bitrateBps;
  }
  public function setContainer( $container) {
    $this->container = $container;
  }
  public function getContainer() {
    return $this->container;
  }
  public function setCreationTime( $creationTime) {
    $this->creationTime = $creationTime;
  }
  public function getCreationTime() {
    return $this->creationTime;
  }
  public function setDurationMs( $durationMs) {
    $this->durationMs = $durationMs;
  }
  public function getDurationMs() {
    return $this->durationMs;
  }
  public function setFileName( $fileName) {
    $this->fileName = $fileName;
  }
  public function getFileName() {
    return $this->fileName;
  }
  public function setFileSize( $fileSize) {
    $this->fileSize = $fileSize;
  }
  public function getFileSize() {
    return $this->fileSize;
  }
  public function setFileType( $fileType) {
    $this->fileType = $fileType;
  }
  public function getFileType() {
    return $this->fileType;
  }
  public function setRecordingLocation(GeoPoint $recordingLocation) {
    $this->recordingLocation = $recordingLocation;
  }
  public function getRecordingLocation() {
    return $this->recordingLocation;
  }
  public function setVideoStreams(/* array(VideoFileDetailsVideoStream) */ $videoStreams) {
    $this->assertIsArray($videoStreams, 'VideoFileDetailsVideoStream', __METHOD__);
    $this->videoStreams = $videoStreams;
  }
  public function getVideoStreams() {
    return $this->videoStreams;
  }
}

class VideoFileDetailsAudioStream extends Model {
  public $bitrateBps;
  public $channelCount;
  public $codec;
  public $vendor;
  public function setBitrateBps( $bitrateBps) {
    $this->bitrateBps = $bitrateBps;
  }
  public function getBitrateBps() {
    return $this->bitrateBps;
  }
  public function setChannelCount( $channelCount) {
    $this->channelCount = $channelCount;
  }
  public function getChannelCount() {
    return $this->channelCount;
  }
  public function setCodec( $codec) {
    $this->codec = $codec;
  }
  public function getCodec() {
    return $this->codec;
  }
  public function setVendor( $vendor) {
    $this->vendor = $vendor;
  }
  public function getVendor() {
    return $this->vendor;
  }
}

class VideoFileDetailsVideoStream extends Model {
  public $aspectRatio;
  public $bitrateBps;
  public $codec;
  public $frameRateFps;
  public $heightPixels;
  public $rotation;
  public $vendor;
  public $widthPixels;
  public function setAspectRatio( $aspectRatio) {
    $this->aspectRatio = $aspectRatio;
  }
  public function getAspectRatio() {
    return $this->aspectRatio;
  }
  public function setBitrateBps( $bitrateBps) {
    $this->bitrateBps = $bitrateBps;
  }
  public function getBitrateBps() {
    return $this->bitrateBps;
  }
  public function setCodec( $codec) {
    $this->codec = $codec;
  }
  public function getCodec() {
    return $this->codec;
  }
  public function setFrameRateFps( $frameRateFps) {
    $this->frameRateFps = $frameRateFps;
  }
  public function getFrameRateFps() {
    return $this->frameRateFps;
  }
  public function setHeightPixels( $heightPixels) {
    $this->heightPixels = $heightPixels;
  }
  public function getHeightPixels() {
    return $this->heightPixels;
  }
  public function setRotation( $rotation) {
    $this->rotation = $rotation;
  }
  public function getRotation() {
    return $this->rotation;
  }
  public function setVendor( $vendor) {
    $this->vendor = $vendor;
  }
  public function getVendor() {
    return $this->vendor;
  }
  public function setWidthPixels( $widthPixels) {
    $this->widthPixels = $widthPixels;
  }
  public function getWidthPixels() {
    return $this->widthPixels;
  }
}

class VideoGetRatingResponse extends Model {
  public $etag;
  protected $__itemsType = 'VideoRating';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setItems(/* array(VideoRating) */ $items) {
    $this->assertIsArray($items, 'VideoRating', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
}

class VideoListResponse extends Model {
  public $etag;
  public $eventId;
  protected $__itemsType = 'Video';
  protected $__itemsDataType = 'array';
  public $items;
  public $kind;
  public $nextPageToken;
  protected $__pageInfoType = 'PageInfo';
  protected $__pageInfoDataType = '';
  public $pageInfo;
  public $prevPageToken;
  public $visitorId;
  public function setEtag( $etag) {
    $this->etag = $etag;
  }
  public function getEtag() {
    return $this->etag;
  }
  public function setEventId( $eventId) {
    $this->eventId = $eventId;
  }
  public function getEventId() {
    return $this->eventId;
  }
  public function setItems(/* array(Video) */ $items) {
    $this->assertIsArray($items, 'Video', __METHOD__);
    $this->items = $items;
  }
  public function getItems() {
    return $this->items;
  }
  public function setKind( $kind) {
    $this->kind = $kind;
  }
  public function getKind() {
    return $this->kind;
  }
  public function setNextPageToken( $nextPageToken) {
    $this->nextPageToken = $nextPageToken;
  }
  public function getNextPageToken() {
    return $this->nextPageToken;
  }
  public function setPageInfo(PageInfo $pageInfo) {
    $this->pageInfo = $pageInfo;
  }
  public function getPageInfo() {
    return $this->pageInfo;
  }
  public function setPrevPageToken( $prevPageToken) {
    $this->prevPageToken = $prevPageToken;
  }
  public function getPrevPageToken() {
    return $this->prevPageToken;
  }
  public function setVisitorId( $visitorId) {
    $this->visitorId = $visitorId;
  }
  public function getVisitorId() {
    return $this->visitorId;
  }
}

class VideoMonetizationDetails extends Model {
  protected $__accessType = 'AccessPolicy';
  protected $__accessDataType = '';
  public $access;
  public function setAccess(AccessPolicy $access) {
    $this->access = $access;
  }
  public function getAccess() {
    return $this->access;
  }
}

class VideoPlayer extends Model {
  public $embedHtml;
  public function setEmbedHtml( $embedHtml) {
    $this->embedHtml = $embedHtml;
  }
  public function getEmbedHtml() {
    return $this->embedHtml;
  }
}

class VideoProcessingDetails extends Model {
  public $editorSuggestionsAvailability;
  public $fileDetailsAvailability;
  public $processingFailureReason;
  public $processingIssuesAvailability;
  protected $__processingProgressType = 'VideoProcessingDetailsProcessingProgress';
  protected $__processingProgressDataType = '';
  public $processingProgress;
  public $processingStatus;
  public $tagSuggestionsAvailability;
  public $thumbnailsAvailability;
  public function setEditorSuggestionsAvailability( $editorSuggestionsAvailability) {
    $this->editorSuggestionsAvailability = $editorSuggestionsAvailability;
  }
  public function getEditorSuggestionsAvailability() {
    return $this->editorSuggestionsAvailability;
  }
  public function setFileDetailsAvailability( $fileDetailsAvailability) {
    $this->fileDetailsAvailability = $fileDetailsAvailability;
  }
  public function getFileDetailsAvailability() {
    return $this->fileDetailsAvailability;
  }
  public function setProcessingFailureReason( $processingFailureReason) {
    $this->processingFailureReason = $processingFailureReason;
  }
  public function getProcessingFailureReason() {
    return $this->processingFailureReason;
  }
  public function setProcessingIssuesAvailability( $processingIssuesAvailability) {
    $this->processingIssuesAvailability = $processingIssuesAvailability;
  }
  public function getProcessingIssuesAvailability() {
    return $this->processingIssuesAvailability;
  }
  public function setProcessingProgress(VideoProcessingDetailsProcessingProgress $processingProgress) {
    $this->processingProgress = $processingProgress;
  }
  public function getProcessingProgress() {
    return $this->processingProgress;
  }
  public function setProcessingStatus( $processingStatus) {
    $this->processingStatus = $processingStatus;
  }
  public function getProcessingStatus() {
    return $this->processingStatus;
  }
  public function setTagSuggestionsAvailability( $tagSuggestionsAvailability) {
    $this->tagSuggestionsAvailability = $tagSuggestionsAvailability;
  }
  public function getTagSuggestionsAvailability() {
    return $this->tagSuggestionsAvailability;
  }
  public function setThumbnailsAvailability( $thumbnailsAvailability) {
    $this->thumbnailsAvailability = $thumbnailsAvailability;
  }
  public function getThumbnailsAvailability() {
    return $this->thumbnailsAvailability;
  }
}

class VideoProcessingDetailsProcessingProgress extends Model {
  public $partsProcessed;
  public $partsTotal;
  public $timeLeftMs;
  public function setPartsProcessed( $partsProcessed) {
    $this->partsProcessed = $partsProcessed;
  }
  public function getPartsProcessed() {
    return $this->partsProcessed;
  }
  public function setPartsTotal( $partsTotal) {
    $this->partsTotal = $partsTotal;
  }
  public function getPartsTotal() {
    return $this->partsTotal;
  }
  public function setTimeLeftMs( $timeLeftMs) {
    $this->timeLeftMs = $timeLeftMs;
  }
  public function getTimeLeftMs() {
    return $this->timeLeftMs;
  }
}

class VideoProjectDetails extends Model {
  public $tags;
  public function setTags(/* array(string) */ $tags) {
    $this->assertIsArray($tags, 'string', __METHOD__);
    $this->tags = $tags;
  }
  public function getTags() {
    return $this->tags;
  }
}

class VideoRating extends Model {
  public $rating;
  public $videoId;
  public function setRating( $rating) {
    $this->rating = $rating;
  }
  public function getRating() {
    return $this->rating;
  }
  public function setVideoId( $videoId) {
    $this->videoId = $videoId;
  }
  public function getVideoId() {
    return $this->videoId;
  }
}

class VideoRecordingDetails extends Model {
  protected $__locationType = 'GeoPoint';
  protected $__locationDataType = '';
  public $location;
  public $locationDescription;
  public $recordingDate;
  public function setLocation(GeoPoint $location) {
    $this->location = $location;
  }
  public function getLocation() {
    return $this->location;
  }
  public function setLocationDescription( $locationDescription) {
    $this->locationDescription = $locationDescription;
  }
  public function getLocationDescription() {
    return $this->locationDescription;
  }
  public function setRecordingDate( $recordingDate) {
    $this->recordingDate = $recordingDate;
  }
  public function getRecordingDate() {
    return $this->recordingDate;
  }
}

class VideoSnippet extends Model {
  public $categoryId;
  public $channelId;
  public $channelTitle;
  public $description;
  public $publishedAt;
  public $tags;
  protected $__thumbnailsType = 'ThumbnailDetails';
  protected $__thumbnailsDataType = '';
  public $thumbnails;
  public $title;
  public function setCategoryId( $categoryId) {
    $this->categoryId = $categoryId;
  }
  public function getCategoryId() {
    return $this->categoryId;
  }
  public function setChannelId( $channelId) {
    $this->channelId = $channelId;
  }
  public function getChannelId() {
    return $this->channelId;
  }
  public function setChannelTitle( $channelTitle) {
    $this->channelTitle = $channelTitle;
  }
  public function getChannelTitle() {
    return $this->channelTitle;
  }
  public function setDescription( $description) {
    $this->description = $description;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setPublishedAt( $publishedAt) {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt() {
    return $this->publishedAt;
  }
  public function setTags(/* array(string) */ $tags) {
    $this->assertIsArray($tags, 'string', __METHOD__);
    $this->tags = $tags;
  }
  public function getTags() {
    return $this->tags;
  }
  public function setThumbnails(ThumbnailDetails $thumbnails) {
    $this->thumbnails = $thumbnails;
  }
  public function getThumbnails() {
    return $this->thumbnails;
  }
  public function setTitle( $title) {
    $this->title = $title;
  }
  public function getTitle() {
    return $this->title;
  }
}

class VideoStatistics extends Model {
  public $commentCount;
  public $dislikeCount;
  public $favoriteCount;
  public $likeCount;
  public $viewCount;
  public function setCommentCount( $commentCount) {
    $this->commentCount = $commentCount;
  }
  public function getCommentCount() {
    return $this->commentCount;
  }
  public function setDislikeCount( $dislikeCount) {
    $this->dislikeCount = $dislikeCount;
  }
  public function getDislikeCount() {
    return $this->dislikeCount;
  }
  public function setFavoriteCount( $favoriteCount) {
    $this->favoriteCount = $favoriteCount;
  }
  public function getFavoriteCount() {
    return $this->favoriteCount;
  }
  public function setLikeCount( $likeCount) {
    $this->likeCount = $likeCount;
  }
  public function getLikeCount() {
    return $this->likeCount;
  }
  public function setViewCount( $viewCount) {
    $this->viewCount = $viewCount;
  }
  public function getViewCount() {
    return $this->viewCount;
  }
}

class VideoStatus extends Model {
  public $embeddable;
  public $failureReason;
  public $license;
  public $privacyStatus;
  public $publicStatsViewable;
  public $rejectionReason;
  public $uploadStatus;
  public function setEmbeddable( $embeddable) {
    $this->embeddable = $embeddable;
  }
  public function getEmbeddable() {
    return $this->embeddable;
  }
  public function setFailureReason( $failureReason) {
    $this->failureReason = $failureReason;
  }
  public function getFailureReason() {
    return $this->failureReason;
  }
  public function setLicense( $license) {
    $this->license = $license;
  }
  public function getLicense() {
    return $this->license;
  }
  public function setPrivacyStatus( $privacyStatus) {
    $this->privacyStatus = $privacyStatus;
  }
  public function getPrivacyStatus() {
    return $this->privacyStatus;
  }
  public function setPublicStatsViewable( $publicStatsViewable) {
    $this->publicStatsViewable = $publicStatsViewable;
  }
  public function getPublicStatsViewable() {
    return $this->publicStatsViewable;
  }
  public function setRejectionReason( $rejectionReason) {
    $this->rejectionReason = $rejectionReason;
  }
  public function getRejectionReason() {
    return $this->rejectionReason;
  }
  public function setUploadStatus( $uploadStatus) {
    $this->uploadStatus = $uploadStatus;
  }
  public function getUploadStatus() {
    return $this->uploadStatus;
  }
}

class VideoSuggestions extends Model {
  public $editorSuggestions;
  public $processingErrors;
  public $processingHints;
  public $processingWarnings;
  protected $__tagSuggestionsType = 'VideoSuggestionsTagSuggestion';
  protected $__tagSuggestionsDataType = 'array';
  public $tagSuggestions;
  public function setEditorSuggestions(/* array(string) */ $editorSuggestions) {
    $this->assertIsArray($editorSuggestions, 'string', __METHOD__);
    $this->editorSuggestions = $editorSuggestions;
  }
  public function getEditorSuggestions() {
    return $this->editorSuggestions;
  }
  public function setProcessingErrors(/* array(string) */ $processingErrors) {
    $this->assertIsArray($processingErrors, 'string', __METHOD__);
    $this->processingErrors = $processingErrors;
  }
  public function getProcessingErrors() {
    return $this->processingErrors;
  }
  public function setProcessingHints(/* array(string) */ $processingHints) {
    $this->assertIsArray($processingHints, 'string', __METHOD__);
    $this->processingHints = $processingHints;
  }
  public function getProcessingHints() {
    return $this->processingHints;
  }
  public function setProcessingWarnings(/* array(string) */ $processingWarnings) {
    $this->assertIsArray($processingWarnings, 'string', __METHOD__);
    $this->processingWarnings = $processingWarnings;
  }
  public function getProcessingWarnings() {
    return $this->processingWarnings;
  }
  public function setTagSuggestions(/* array(VideoSuggestionsTagSuggestion) */ $tagSuggestions) {
    $this->assertIsArray($tagSuggestions, 'VideoSuggestionsTagSuggestion', __METHOD__);
    $this->tagSuggestions = $tagSuggestions;
  }
  public function getTagSuggestions() {
    return $this->tagSuggestions;
  }
}

class VideoSuggestionsTagSuggestion extends Model {
  public $categoryRestricts;
  public $tag;
  public function setCategoryRestricts(/* array(string) */ $categoryRestricts) {
    $this->assertIsArray($categoryRestricts, 'string', __METHOD__);
    $this->categoryRestricts = $categoryRestricts;
  }
  public function getCategoryRestricts() {
    return $this->categoryRestricts;
  }
  public function setTag( $tag) {
    $this->tag = $tag;
  }
  public function getTag() {
    return $this->tag;
  }
}

class VideoTopicDetails extends Model {
  public $topicIds;
  public function setTopicIds(/* array(string) */ $topicIds) {
    $this->assertIsArray($topicIds, 'string', __METHOD__);
    $this->topicIds = $topicIds;
  }
  public function getTopicIds() {
    return $this->topicIds;
  }
}

class WatchSettings extends Model {
  public $backgroundColor;
  public $featuredPlaylistId;
  public $textColor;
  public function setBackgroundColor( $backgroundColor) {
    $this->backgroundColor = $backgroundColor;
  }
  public function getBackgroundColor() {
    return $this->backgroundColor;
  }
  public function setFeaturedPlaylistId( $featuredPlaylistId) {
    $this->featuredPlaylistId = $featuredPlaylistId;
  }
  public function getFeaturedPlaylistId() {
    return $this->featuredPlaylistId;
  }
  public function setTextColor( $textColor) {
    $this->textColor = $textColor;
  }
  public function getTextColor() {
    return $this->textColor;
  }
}
