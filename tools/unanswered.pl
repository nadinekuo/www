#!/usr/bin/perl

use strict;
use warnings;

use LWP::Simple;

# some constants (do not use locale specific values since the server is in the
# US no matter what my locale is).
my @months = ("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
my $url_fmt = "http://lists.einsteintoolkit.org/pipermail/users/%04d-%s/date.html";

# these hold the list of emails and the root of the conversations
our (%emails);

# get emails logs for the three months braketing the current one
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime();
for (my $m = -1 ; $m <= 1 ; $m++) {
  my $monthyear = $year * 12 + $mon + $m;
  my $monthname = $months[$monthyear % 12];
  my $fullyear = 1900 + int($monthyear / 12);
  my $url = sprintf($url_fmt, $fullyear, $monthname);
  my $content = get($url);
  parse_content($content, $url) if $content;
} 

# if there is an email thread with either only a single post or where the last
# poster is the original poster then they are candidates for unanswered emails
print "<ul>\n";
foreach my $key (sort keys %emails) {
  my @authors = @${$emails{$key}->{senders}};
  my $num_authors = scalar @authors;
  if($num_authors == 1 or $authors[0] eq $authors[-1]) {
    if($num_authors == 1 and 
       $authors[0] eq "Roland Haas" and
       $key =~ m/\[Users\] meeting minutes for/) {
     next;
    }
    print "<li>".sanitize("$key ($authors[0])").": <a href='".url(${$emails{$key}->{roots}})."'>root</a>";
    print " <a href='".url(${$emails{$key}->{tails}})."'>tail</a>" if $num_authors > 1;
    print "</li>\n";
  }
}
print "</ul>\n";

sub parse_content {
  my ($content, $monthurl) = @_;
  our (%emails);

  $monthurl =~ s!/[^/]*$!!;

  my @lines = split /\n/,$content;
  my $subject;
  foreach (@lines) {
    if(/^<LI><A HREF="(\d*\.html)">(.*)/) {
      my $url = $1;
      $subject = $2;
      # apparently some subjects have random whitespace (maybe line breaking?)
      $subject =~ s/\s\s*/ /g;
      if(not exists $emails{$subject}) {
        $emails{$subject} = {};
        ${$emails{$subject}->{senders}} = [];
        ${$emails{$subject}->{roots}} = $monthurl . "/" . $url;
      }
      ${$emails{$subject}->{tails}} = $monthurl . "/" . $url;
    } elsif(/^<I>(.*)/) {
      my $sender = $1;
      push @${$emails{$subject}->{senders}}, ($sender);
    }
  }
}

sub sanitize {
  # a very trivial text sanitizer to remove all html tags
  my ($text) = @_;
  $text =~ s/</\&lt;/g;
  $text =~ s/</\&gt;/g;
  return $text;
}

sub url {
  # a very simple URL sanitizer
  my ($url) = @_;
  if($url =~ s![^a-zA-Z0-9/_:.-]!!g) {
    warn "Invalid characcters in url $_[0]";
  }
  return $url;
}

1;
